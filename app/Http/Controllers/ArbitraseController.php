<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Arbitrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Ewallet;
use App\Models\Transaction;
use App\Models\Task;

class ArbitraseController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $workerProfile = $user->workerProfile;
        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->role === 'admin') {
            $arbitrases = Arbitrase::all();
        } else {
            $arbitrases = Arbitrase::where('client_id', $user->id)
                ->orWhere('worker_id', $workerProfile->user_id)
                ->get();
        }

        return view('General.arbitrase', compact('arbitrases'));
    }

    public function indexUser()
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login');
        }

        $workerProfile = $user->workerProfile;

        $arbitrases = Arbitrase::query();

        if ($user->role === 'client') {
            $arbitrases = $arbitrases->where('client_id', $user->id);
        } elseif ($user->role === 'worker' && $workerProfile) {
            $arbitrases = $arbitrases->where('worker_id', $user->id);
        } else {
            return abort(403, 'Unauthorized role');
        }

        return view('General.arbitrase', [
            'arbitrases' => $arbitrases->get()
        ]);
    }


    public function store(Request $request)
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Buat data sederhana dari request (tanpa validasi/cek role)
        $workerProfile = $user->workerProfile;

        $data = [
            'task_id' => $request->task_id,
            'reason' => $request->reason ?? 'Tidak ada alasan',
            'status' => 'under review',
            'created_at' => now(),
            'client_id' => $request->client_id ?? $user->id,
            'worker_id' => $request->worker_id ?? ($workerProfile ? $workerProfile->id : null),
        ];
        Task::where('id', $request->task_id)->update(['status' => 'on-hold']);
        // dd($request->all());

        // Simpan ke database
        Arbitrase::create($data);

        return back()->with('success', 'Data arbitrase berhasil ditambahkan, silahkan menunggu konfirmasi dari admin.');
    }

    public function show() {}


    public function reject($id)
    {
        $arbitrase = Arbitrase::find($id);

        if (!$arbitrase) {
            return back()->withErrors(['message' => 'Data arbitrase tidak ditemukan.']);
        }

        // Set status menjadi rejected
        $arbitrase->status = 'resolved';

        $arbitrase->save();

        $user = Auth::user();
        $worker = $arbitrase->worker;
        $client = $arbitrase->client;

        $message = 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah ditolak oleh admin.';

        // Notifikasi untuk worker
        if ($worker) {
            Notification::create([
                'user_id' => $worker->id,
                'sender_name' => $user->nama_lengkap,
                'message' => $message,
                'is_read' => false,
            ]);
        }

        // Notifikasi untuk client
        if ($client) {
            Notification::create([
                'user_id' => $client->id,
                'sender_name' => $user->nama_lengkap,
                'message' => $message,
                'is_read' => false,
            ]);
        }

        return back()->with('success', 'Arbitrase ditolak dan status telah diubah ke "rejected".');
    }

    public function accept($id, Request $request)
    {
        // Validasi input
        $request->validate([
            'persentase' => 'required|numeric|min:0|max:100',
        ]);

        $arbitrase = Arbitrase::find($id);
        if (!$arbitrase) {
            return back()->withErrors(['message' => 'Arbitrase tidak ditemukan.']);
        }

        DB::beginTransaction();

        try {
            // Ubah status arbitrase
            $arbitrase->status = 'resolved';
            $arbitrase->save();

            // Ubah status task jika perlu
            $task = $arbitrase->task;
            if ($task && $task->status === 'in progress') {
                Task::where('id', $arbitrase->task_id)->update(['status' => 'arbitrase-completed']);
            }

            $user = Auth::user();
            $worker = $arbitrase->worker;
            $client = $arbitrase->client;
            $total = $task->price;

            // Hitung pembagian dana
            $persentaseWorker = (int) $request->persentase;
            $amountToWorker = $total * ($persentaseWorker / 100);
            $amountToClient = $total - $amountToWorker;

            // Update ewallet worker
            $ewalletWorker = Ewallet::where('user_id', $worker->id)->firstOrFail();
            $ewalletWorker->balance += $amountToWorker;
            $ewalletWorker->save();

            // Update ewallet client
            $ewalletClient = Ewallet::where('user_id', $client->id)->firstOrFail();
            $ewalletClient->balance += $amountToClient;
            $ewalletClient->save();

            // Buat order ID unik
            $orderId = 'pengembalian-' . $task->id . '-' . $client->id . $worker->id . '-' . time();
            // Simpan transaksi untuk worker
            Transaction::create([
                'order_id' => $orderId,
                'task_id' => $task->id,
                'worker_id' => $worker->id,
                'client_id' => null,
                'amount' => $amountToWorker,
                'status' => 'success',
                'payment_method' => 'ewallet',
                'type' => 'refund',
            ]);

            Transaction::create([
                'order_id' => $orderId . '-client',
                'task_id' => $task->id,
                'worker_id' => null,
                'client_id' => $client->id,
                'amount' => $amountToClient,
                'status' => 'success',
                'payment_method' => 'ewallet',
                'type' => 'refund',
            ]);



            // Kirim notifikasi
            $notifMessage = 'Arbitrase dengan reason ' . $arbitrase->reason . ' telah diterima dan akan ditindaklanjuti sesuai kesepakatan.';
            foreach ([$worker, $client] as $u) {
                $notif = Notification::create([
                    'user_id' => $u->id,
                    'sender_name' => $user->nama_lengkap,
                    'message' => $notifMessage,
                    'is_read' => false,
                ]);
            }
            DB::commit();
            // Kirim notifikasi ke admin
            return back()->with('success', 'Arbitrase diterima dan dana dibagi sesuai persentase.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
