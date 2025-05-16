<?php

namespace App\Http\Controllers;

use App\Models\Arbitrase;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

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

        // dd($request->all());

        // Simpan ke database
        Arbitrase::create($data);

        return back()->with('success', 'Data arbitrase berhasil ditambahkan.');
    }

    public function show() {}

    public function accept($id)
    {
        $arbitrase = Arbitrase::find($id);
        if ($arbitrase) {
            // Ubah status arbitrase
            $arbitrase->status = 'resolved';
            $arbitrase->save();

            // Ambil task terkait
            $task = $arbitrase->task; // Pastikan ada relasi 'task' di model Arbitrase
            if ($task && $task->status === 'in progress') {
                $task->status = 'completed';
                $task->save();
            }

            $user = Auth::user();

            // Ambil worker dan client terkait
            $worker = $arbitrase->worker;
            $client = $arbitrase->client;

            // Buat notifikasi untuk worker
            Notification::create([
                'user_id' => $worker->id,
                'sender_name' => $user->nama_lengkap,
                'message' => 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah diterima dan akan ditindak lanjuti sesuai kesepakatan.',
                'is_read' => false,
            ]);

            // Buat notifikasi untuk client
            Notification::create([
                'user_id' => $client->id,
                'sender_name' => $user->nama_lengkap,
                'message' => 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah diterima dan akan ditindak lanjuti sesuai kesepakatan.',
                'is_read' => false,
            ]);

            return back()->with('success', 'Arbitrase diterima dan task diselesaikan.');
        }

        return back()->withErrors(['message' => 'Arbitrase tidak ditemukan.']);
    }


    public function reject($id)
    {
        $arbitrase = Arbitrase::find($id);
        if ($arbitrase) {
            // Update status menjadi 'under review'
            $arbitrase->status = 'under review';
            $arbitrase->save();

            // Simulasikan proses setelah status menjadi 'resolved'
            $arbitrase->status = 'resolved';
            $arbitrase->save();

            $user = Auth::user();

            // Ambil worker dan client terkait
            $worker = $arbitrase->worker;
            $client = $arbitrase->client;

            // Buat notifikasi untuk worker
            Notification::create([
                'user_id' => $worker->id,
                'sender_name' => $user->nama_lengkap,
                'message' => 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah ditolak.',
                'is_read' => false,
            ]);

            // Buat notifikasi untuk client
            Notification::create([
                'user_id' => $client->id,
                'sender_name' => $user->nama_lengkap,
                'message' => 'Arbitrase dengan reason <b>"' . $arbitrase->reason . '"</b> telah ditolak.',
                'is_read' => false,
            ]);

            return back()->with('success', 'Arbitrase ditolak dan status telah diubah.');
        }

        return back()->withErrors(['message' => 'Arbitrase tidak ditemukan.']);
    }
}
