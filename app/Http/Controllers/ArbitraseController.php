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
use App\Models\WorkerProfile;
use App\Models\User;

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

        // Ambil task
        $task = Task::findOrFail($request->task_id);

        // Ambil user client dan worker
        $client = $task->client; // pastikan relasi Task -> client didefinisikan
        $workerUser = $task->workerProfile?->user;
        
        $data = [
            'task_id' => $task,
            'reason' => $request->reason ?? 'Tidak ada alasan',
            'status' => 'under review',
            'created_at' => now(),
            'pelapor' => $user->id,
        ];
        
        Task::where('id', $task)->update(['status' => 'on-hold']);
        // Simpan ke database
        Arbitrase::create($data);
        $notifMessage = 'Pengguna ' . $user->nama_lengkap . ' melaporkan tugas "' . $task->title . '" ke pihak Empowr.';

        foreach ([$client, $workerUser] as $recipient) {
            if ($recipient) {
                Notification::create([
                    'user_id' => $recipient->id,
                    'sender_name' => $user->nama_lengkap,
                    'message' => $notifMessage,
                    'is_read' => false,
                ]);
            }
        }

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

        $task = $arbitrase->task;
        $task->status = 'in progress';

        $task->save();
        $arbitrase->save();

        $user = Auth::user();
        $worker = $arbitrase->task->worker->user;
        $client = $arbitrase->task->client;

        $message = 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah ditolak oleh admin.';

        // Notifikasi untuk worker
        if ($worker) {
            $notifWorker = Notification::create([
                'user_id' => $worker->id,
                'sender_name' => $user->nama_lengkap,
                'message' => $message,
                'is_read' => false,
            ]);
        }

        if ($client) {
            $notifClient = Notification::create([
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
            if ($task && $task->status === 'on-hold') {
                Task::where('id', $arbitrase->task_id)->update(['status' => 'arbitrase-completed']);
            }

            $user = Auth::user();
            $total = $task->price;
            $client = user::find($task->client_id);
            $workerProfile = workerProfile::find($task->profile_id);
            $workerIdEwallet= $workerProfile->user;

            if($arbitrase->pelapor == $client->id){
                // Hitung pembagian dana
                $persentase = (int) $request->persentase;
                $amountToClient = $total * ($persentase / 100);
                $amountToWorker = $total - $amountToClient;
            }else{
                // Hitung pembagian dana
                $persentase = (int) $request->persentase;
                $amountToWorker = $total * ($persentase / 100);
                $amountToClient = $total - $amountToWorker;
                
            }

            // Update ewallet worker
            $ewalletWorker = Ewallet::where('user_id', $workerIdEwallet->id)->firstOrFail();;
           
            $ewalletWorker->balance += $amountToWorker;
            $ewalletWorker->save();

            // Update ewallet client
            $ewalletClient = Ewallet::where('user_id', $client->id)->firstOrFail();
            $ewalletClient->balance += $amountToClient;
            $ewalletClient->save();

            // Buat order ID unik
            $orderId = 'pengembalian-' . $task->id . '-' . $client->id . $workerProfile->id . '-' . time();
            // Simpan transaksi untuk worker
            Transaction::create([
                'order_id' => $orderId,
                'task_id' => $task->id,
                'worker_id' => $arbitrase->task->worker->id,
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
            $notifMessage = 'Arbitrase dengan reason ' . $arbitrase->reason . ' telah diselesaikan dengan pembagian yang sudah ditentukan';
            foreach ([$workerIdEwallet, $client] as $u) {
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


    public function batalkanLaporan(Request $request)
    {
         
        $request->validate([
            'task_id' => 'required|exists:task,id',
        ]);
        $user = Auth::user();

        if ($user->role === 'worker') {
            $pengajuId = $user->workerProfile->id;
        } else {
            $pengajuId= $user->id;
        }

        // Cari arbitrase berdasarkan pengaju
        $arbitrase = Arbitrase::where('pelapor', $pengajuId)
            ->whereIn('status', ['open', 'under review'])
            ->where('task_id', $request->task_id)
            ->latest()
            ->first();

        $taskId = $request->task_id; // atau $request->task_id kalau pakai input
        $task = Task::findOrFail($taskId);

        
        if ($arbitrase->task_id != $task->id) {
            return back()->withErrors(['message' => 'Laporan arbitrase tidak cocok dengan tugas yang dipilih.']);
        }

        // Kembalikan status task jadi 'on-progress'
        $task = $arbitrase->task;
        if ($task) {
            $task->status = 'in progress';
            $task->save();
        }



        // Update status arbitrase
        $arbitrase->status = 'cancelled';
        $arbitrase->save();

        $worker = optional($arbitrase->task->worker)->user;
        $client = $arbitrase->task->client;

        $notifMessage = 'Laporan tugas ' . $arbitrase->task->title . ' telah dibatalkan oleh ' . $user->nama_lengkap;

        if ($worker) {
            Notification::create([
                'user_id' => $worker->id,
                'sender_name' => $user->nama_lengkap,
                'message' => $notifMessage,
                'is_read' => false,
            ]);
        }

        // Notifikasi untuk client
        if ($client) {
            Notification::create([
                'user_id' => $client->id,
                'sender_name' => $user->nama_lengkap,
                'message' => $notifMessage,
                'is_read' => false,
            ]);
        }



        return back()->with('success', 'Laporan arbitrase berhasil dibatalkan.');
    }
}
