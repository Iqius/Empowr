<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\workerAffiliated;
use App\Models\workerAffiliatedLogs;
use App\Models\WorkerProfile;
use App\Models\Notification;

class affiliatedController extends Controller
{
    // Halaman progress
    // Controller
public function index($id){
    $user = Auth::user();
    if($user->role == 'admin'){
        $affiliation = workerAffiliated::where('profile_id', $id)->firstOrFail();
    }elseif($user->role == 'worker'){
        $affiliation = workerAffiliated::findOrFail($id);
    }
   
    // Ambil semua logs berdasarkan affiliation_id
    $logs = workerAffiliatedLogs::where('affiliation_id', $affiliation->id)
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

    // Tabel request pengajuan afiliasi worker
    public function pengajuanAffiliasiWorkerView(){
        $data = workerAffiliated::all();
        return view("admin.Affiliation.affiliationListWorkerRequest", compact('data'));
    }

    public function updateStatusAffiliate(Request $request, $id){
        // Ambil data dari tabel workerAffiliated berdasarkan id
        $affiliation = workerAffiliated::findOrFail($id);

        // Jika status_decision saat ini adalah 'pending'
        if ($affiliation->status === 'pending') {
            // Ubah menjadi 'under review'
            $affiliation->status = 'reviewed';
            $affiliation->status_decision = 'approve';
            $affiliation->save();

            workerAffiliatedLogs::create([
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

            workerAffiliatedLogs::create([
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

            workerAffiliatedLogs::create([
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

            workerAffiliatedLogs::create([
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

    public function rejectStatusAffiliate(Request $request, $id)
    {
        $affiliation = workerAffiliated::findOrFail($id);
        $lastLog = $affiliation->logs()->latest()->first();
        $admin = $lastLog?->admin; // null-safe jika $lastLog tidak ada

        $rejectableStatuses = ['reviewed', 'interview', 'result'];

        if (in_array($affiliation->status, $rejectableStatuses)) {
            $affiliation->status_decision = 'rejected';
            $affiliation->save();
            // Buat log penolakan
            workerAffiliatedLogs::create([
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


    public function ajukanUlangAffiliate($id){
        $affiliation = workerAffiliated::findOrFail($id);
        
        // Hapus semua logs yang terkait dengan affiliation_id ini
        workerAffiliatedLogs::where('affiliation_id', $affiliation->id)->delete();

        $affiliation->status = 'pending';
        $affiliation->status_decision = 'waiting';
        $affiliation->save();
        return redirect()->back()->with('success', 'Status berhasil diperbarui.');

    }


    public function interviewDate(Request $request, $id){
        $affiliation = workerAffiliated::findOrFail($id);
        if ($affiliation->status === 'interview'){
            // Ubah menjadi 'under review'
            $affiliation->link_meet = $request->input('meeting_link');
            $affiliation->jadwal_interview = $request->input('schedule');
            $affiliation->save();
        }

        return redirect()->back()->with('success', 'Status berhasil diperbarui.');
    }


    // PENGAJUAN AFFILIATED KE ADMIN
    public function createAffiliatedOrder(Request $request)
    {
        $request->validate([
            'identity_photo' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg,jpg|max:10240',
            'selfie_with_id' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg,jpg|max:10240',
            'keahlian_affiliate' => 'nullable|string|max:255',
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
        workerAffiliated::create([
            'profile_id' => $user->workerProfile->id,
            'identity_photo' => $identityPhotoPath,
            'selfie_with_id' => $selfieWithIdPath,
            'keahlian_affiliate' => json_encode($request->kategoriWorker),
            'status' => 'pending',
        ]);

        return redirect()->back()->with('success-order-affiliated', 'Pendaftaran berhasil dikirim!');
    }
}
