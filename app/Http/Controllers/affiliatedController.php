<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkerAffiliated;
use App\Models\WorkerAffiliatedLogs;
use App\Models\WorkerProfile;
use App\Models\Notification;
use App\Models\task;
use App\Models\TaskApplication;


class AffiliatedController extends Controller
{
    // Halaman progress pengajuan affiliate worker
    public function index($id){
        $user = Auth::user();
        if($user->role == 'admin'){
            $affiliation = WorkerAffiliated::where('profile_id', $id)->firstOrFail();
        }elseif($user->role == 'worker'){
            $affiliation = WorkerAffiliated::findOrFail($id);
        }
    
        // Ambil semua logs berdasarkan affiliation_id
        $logs = WorkerAffiliatedLogs::where('affiliation_id', $affiliation->id)
                ->orderBy('created_at')
                ->get();
        
        // Definisi tahapan
        $stepList = ['pending', 'reviewed', 'interview', 'result'];
        $stepsStatus = [];
        $rejected = false;
        
        foreach ($stepList as $step) {
            if ($rejected) {
                // Jika sebelumnya sudah ditolak, tandai sebagai auto-rejected
                $stepsStatus[$step] = 'auto-rejected';
                continue;
            }
            
            // Cari log yang sesuai dengan step ini
            $log = $logs->filter(function ($log) use ($step) {
                return strtolower($log->status) === strtolower($step);
            })->last(); // Ambil yang terakhir jika ada beberapa
            
            if ($log) {
                $stepsStatus[$step] = $log->status_decision;
                // Jika ditolak, set flag rejected
                if ($log->status_decision === 'rejected') {
                    $rejected = true;
                }
            } else {
                // Jika tidak ada log untuk step ini, set sebagai null (belum diproses)
                $stepsStatus[$step] = null;
            }
        }
        
        return view("worker.progressAffiliated", compact('affiliation', 'stepsStatus', 'logs'));
    }

    // Tabel request pengajuan afiliasi worker untuk admin
    public function pengajuanAffiliasiWorkerView(){
        $data = WorkerAffiliated::all();
        return view("admin.Affiliation.affiliationListWorkerRequest", compact('data'));
    }

    // Update status progress pengajuan affiliasi worker untuk admin
    public function updateStatusAffiliate(Request $request, $id){
        // Ambil data dari tabel WorkerAffiliated berdasarkan id
        $affiliation = WorkerAffiliated::findOrFail($id);

        // Jika status_decision saat ini adalah 'pending'
        if ($affiliation->status === 'pending') {
            // Ubah menjadi 'under review'
            $affiliation->status = 'reviewed';
            $affiliation->status_decision = 'approve';
            $affiliation->save();

            WorkerAffiliatedLogs::create([
                'affiliation_id' => $affiliation->id,
                'status_decision' => 'approved',
                'status' => 'pending',
                'action_admin' => auth()->id(),
            ]);
        }elseif ($affiliation->status === 'reviewed'){
            // Ubah menjadi 'under review'
            $affiliation->status = 'interview';
            $affiliation->status_decision = 'approve';
            $affiliation->save();

            WorkerAffiliatedLogs::create([
                'affiliation_id' => $affiliation->id,
                'status_decision' => 'approved',
                'status' => 'reviewed',
                'action_admin' => auth()->id(),
            ]);
        }elseif($affiliation->status === 'interview'){
            // Ubah menjadi 'under review'
            $affiliation->status = 'result';
            $affiliation->status_decision = 'approve';
            $affiliation->save();

            WorkerAffiliatedLogs::create([
                'affiliation_id' => $affiliation->id,
                'status_decision' => 'approved',
                'status' => 'interview',
                'action_admin' => auth()->id(),
            ]);
        }elseif($affiliation->status === 'result'){
            // Ubah menjadi 'under review'
            $affiliation->status = 'result';
            $affiliation->status_decision = 'approve';
            $affiliation->save();

            WorkerAffiliatedLogs::create([
                'affiliation_id' => $affiliation->id,
                'status_decision' => 'approved',
                'status' => 'result',
                'action_admin' => auth()->id(),
            ]);

            $workerProfile = $affiliation->workerProfile;

            // Contoh update field (ganti dengan field yang sesuai)
            $workerProfile->empowr_affiliate = true;
            $workerProfile->keahlian_affiliate = $affiliation->keahlian_affiliate;
            $workerProfile->identity_photo = $affiliation->identity_photo;
            $workerProfile->selfie_with_id = $affiliation->selfie_with_id;
            $workerProfile->save();
        }

        // Redirect kembali atau kirim response
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }

    // Penolakan pengajuan affiliasi worker untuk admin
    public function rejectStatusAffiliate(Request $request, $id)
    {
        $affiliation = WorkerAffiliated::findOrFail($id);
        $lastLog = $affiliation->logs()->latest()->first();
        $admin = $lastLog?->admin; // null-safe jika $lastLog tidak ada

        $rejectableStatuses = ['reviewed', 'interview', 'result'];

        if (in_array($affiliation->status, $rejectableStatuses)) {
            $affiliation->status_decision = 'rejected';
            $affiliation->save();
            // Buat log penolakan
            WorkerAffiliatedLogs::create([
                'affiliation_id' => $affiliation->id,
                'status' => $affiliation->status,
                'status_decision' => 'rejected',
                'action_admin' => auth()->id(),
            ]);

            Notification::create([
                'user_id' => $affiliation->workerProfile->user->id,
                'sender_name' => $admin->nama_lengkap,
                'message' => 'Maaf pengajuan affiliate telah ditolak.',
                'is_read' => false,
            ]);

            return redirect()->back()->with('success', 'Status berhasil diperbarui.');
        }

        return redirect()->back()->with('error', 'Status saat ini tidak bisa ditolak.');
    }

    // Menambahkan jadwal interview worker untuk admin
    public function interviewDate(Request $request, $id){
        $affiliation = WorkerAffiliated::findOrFail($id);
        if ($affiliation->status === 'interview'){
            // Ubah menjadi 'under review'
            $affiliation->link_meet = $request->input('meeting_link');
            $affiliation->jadwal_interview = $request->input('schedule');
            $affiliation->save();
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }


    // PENGAJUAN AFFILIATED worker KE ADMIN
    public function createAffiliatedOrder(Request $request)
    {
        $request->validate([
            'identity_photo' => 'required|file|mimes:pdf,doc,docx,png,jpeg,jpg|max:10240',
            'selfie_with_id' => 'required|file|mimes:pdf,doc,docx,png,jpeg,jpg|max:10240',
            'keahlian_affiliate' => 'required|array|min:1',
            'keahlian_affiliate.*' => 'string|max:255',
        ]);

        // Ambil user_id dari relasi workerProfile
        $user = Auth::user();
        $userId = $user->workerProfile->user_id;

        // Inisialisasi path default
        $identityPhotoPath = null;
        $selfieWithIdPath = null;

        // Simpan file ke folder berdasarkan user_id
        if ($request->hasFile('identity_photo')) {
            $identityPhotoPath = $request->file('identity_photo')
                ->store("affiliator_documents/{$userId}", 'public');
        }

        if ($request->hasFile('selfie_with_id')) {
            $selfieWithIdPath = $request->file('selfie_with_id')
                ->store("affiliator_documents/{$userId}", 'public');
        }

        // Simpan ke tabel worker_verification_affiliations
        WorkerAffiliated::create([
            'profile_id' => $user->workerProfile->id,
            'identity_photo' => $identityPhotoPath,
            'selfie_with_id' => $selfieWithIdPath,
            'keahlian_affiliate' => json_encode($request->kategoriWorker),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success-order-affiliated', 'Pendaftaran berhasil dikirim!');
    }

    public function ajukanUlangAffiliate($id){
        $affiliation = workerAffiliated::findOrFail($id);
        // Hapus semua logs yang terkait dengan affiliation_id ini
        workerAffiliatedLogs::where('affiliation_id', $affiliation->id)->delete();
        $affiliation->status = 'pending';
        $affiliation->status_decision = 'waiting';
        $affiliation->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }


    // -----------------------------------------------------BATAS UNTUK TASK AFFILIATE---------------------------------------------


    // Untuk client mengajukan afiliate ke admin
    public function pengajuanTaskAffiliation($id){
        $task = task::findOrFail($id);

        $task->pengajuan_affiliate = true;
        $task->save();
       
        return redirect()->route('jobs.manage', ['id' => $id])->with('success-tambah-tugas-affiliate', 'Tugas telah masuk antrian admin.');
    }

    // menampilkan list task yg diajukan affiliate ke admin
    public function viewListPengajuanTaskAffiliate(){
        $task = Task::where('pengajuan_affiliate', true)
            ->whereDoesntHave('applications', function ($query) {
                $query->where('affiliated', true);
            })
            ->get();
        $workerProfiles = WorkerProfile::where('empowr_affiliate', true)->get();
        return view('admin.Affiliation.affiliationListTaskClientRequest', compact('workerProfiles'))->with('task', $task);
    }


    // menolak pengajuan task affiliate
    public function rejectTaskAffiliate($id){
        $admin = Auth::user();
        $task = task::where('id', $id)->firstOrFail();

        $task->pengajuan_affiliate  = false;
        $task->save();

        Notification::create([
            'user_id' => $task->client->id,
            'sender_name' => $admin->nama_lengkap,
            'message' => 'Maaf pengajuan affiliate telah ditolak.',
            'is_read' => false,
        ]);
        return redirect()->route('List-pengajuan-task-affiliate.view')->with('success', 'Berhasil menolak permintaan affiliate task!');

    }


    // menambahkan worker ke antrian pelamar tugas
    public function tambahWorkerAffiliateKeTask(Request $request, $id){
        
        $task = Task::findOrFail($id);
        $workerProfiles = $request->worker_id;

        $apakahada = TaskApplication::where('task_id', $task->id)
            ->where('profile_id', $workerProfiles);
        dd($apakahada);

        TaskApplication::create([
            'task_id' => $task->id,
            'profile_id' => $workerProfiles,
            'bidPrice' => $hargaTask + $hargaPajak,
            'catatan' => $request->catatan,
            'status' => 'pending',
            'affiliated' => true,
            'harga_pajak_affiliate' =>  $hargaPajak,
            'applied_at' => now(),
        ]);

        return redirect()->route('List-pengajuan-task-affiliate.view')->with('success', 'Berhasil menugaskan worker affiliate!');
    }
}
