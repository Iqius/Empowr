<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserPaymentAccount;
use App\Models\Sertifikasi;
use App\Models\SertifikasiImage;
use App\Models\Portofolio;
use App\Models\PortofolioImage;
use App\Models\WorkerProfile;
use App\Models\workerAffiliated;
use App\Models\task;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();

        if ($user->role === 'client') {
            $tasks = Task::with('review')
                ->where('client_id', $user->id)
                ->where('status', 'completed')
                ->latest()
                ->get();

            return view('General.profil', [
                'workerProfile' => null,
                'sertifikasi' => collect(),
                'portofolio' => collect(),
                'tasks' => $tasks,
            ]);
        }

        $workerProfile = $user->workerProfile;

        $sertifikasi = Sertifikasi::with('images')->where('worker_id', $workerProfile->id)->get();
        $portofolio = Portofolio::with('images')->where('worker_id', $workerProfile->id)->get();
        $tasks = Task::with('review')
            ->where('profile_id', $workerProfile->id)
            ->where('status', 'completed')
            ->latest()
            ->get();


        return view('General.profil', compact('workerProfile', 'sertifikasi', 'portofolio', 'tasks'));
    }




    public function showProfileWorkerLamar($id)
    {
        // Ambil worker beserta relasi user
        $worker = WorkerProfile::with(['user', 'certifications.images'])->findOrFail($id);

        $data = workerAffiliated::where('profile_id', $worker->id)->get();
        return view('General.lamaranWorkerDetailProfile', compact('worker','data'));
    }


    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string',
            'bio' => 'nullable|string',
            'keahlian' => 'nullable|string',
            'tingkat_keahlian' => 'nullable|string',
            'pengalaman_kerja' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240', // 10MB
            'certificate_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'title_sertifikasi' => 'nullable|string',
            'title' => 'nullable|string',
            'portofolio' => 'nullable|array',
            'portofolio.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',

            // ini di hapus aja nanti
            'account_type' => 'nullable|string',

            // untuk pilihan ewallet
            'wallet_number' => 'nullable|string',
            'ewallet_account_name' => 'nullable|string',
            'ewallet_provider' => 'nullable|string',

            // untuk pilihan bank
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'bank_account_name' => 'nullable|string',
            
        ]);

        // Update user data only if present
        $user->nama_lengkap = $request->nama_lengkap ?? $user->nama_lengkap;
        $user->email = $request->email ?? $user->email;
        $user->nomor_telepon = $request->nomor_telepon ?? $user->nomor_telepon;
        $user->bio = $request->bio ?? $user->bio;
        $user->save();

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

        // CV only if new file uploaded
        if ($request->hasFile('cv')) {
            $workerProfile->cv = $request->file('cv')->store('cv', 'public');
        }

        $workerProfile->keahlian = $request->keahlian ?? $workerProfile->keahlian;
        $workerProfile->tingkat_keahlian = $request->tingkat_keahlian ?? $workerProfile->tingkat_keahlian;
        $workerProfile->linkedin = $request->linkedin ?? $workerProfile->linkedin;
        $workerProfile->pengalaman_kerja = $request->pengalaman_kerja ?? $workerProfile->pengalaman_kerja;
        $workerProfile->pendidikan = $request->pendidikan ?? $workerProfile->pendidikan;

        // Boolean switches
        $workerProfile->empowr_label = $request->has('empowr_label');
        $workerProfile->empowr_affiliate = $request->has('empowr_affiliate');

        $workerProfile->save();

        // Update or create rekening
        $existingAccount = UserPaymentAccount::firstOrNew(['user_id' => $user->id]);

        // ini hapus aja nanti
        $existingAccount->account_type = $request->account_type ?? $existingAccount->account_type;

        
        $existingAccount->wallet_number = $request->wallet_number ?? $existingAccount->wallet_number;
        $existingAccount->ewallet_provider = $request->ewallet_name ?? $existingAccount->ewallet_provider;
        $existingAccount->bank_name = $request->bank_name ?? $existingAccount->bank_name;
        $existingAccount->account_number = $request->bank_number ?? $existingAccount->account_number;
        $existingAccount->bank_account_name = $request->pemilik_bank ?? $existingAccount->bank_account_name;
        $existingAccount->ewallet_account_name = $request->pemilik_ewallet ?? $existingAccount->account_nameewallet_account_name;
        $existingAccount->save();

        // Upload Sertifikat (jika ada)
        if ($request->hasFile('certificate_image')) {
            // If sertifikasi_id exists, we are editing an existing certificate
            if ($request->has('sertifikasi_id')) {
                $sertifikasi = Sertifikasi::find($request->sertifikasi_id);
                $sertifikasi->title = $request->sertifikat_caption;
                $sertifikasi->save();
            } else {
                // Create new sertifikasi if no ID is present
                $sertifikasi = Sertifikasi::create([
                    'worker_id' => $workerProfile->id,
                    'title' => $request->title_sertifikasi,
                ]);
            }

            // Store sertifikat image
            $sertifImage = $request->file('certificate_image')->store('sertifikasi', 'public');

            // Create SertifikasiImage record
            SertifikasiImage::create([
                'sertifikasi_id' => $sertifikasi->id,
                'image' => $sertifImage,
            ]);
        }

        // Update or Create Portofolio (jika ada perubahan)
        if ($request->hasFile('portofolio')) {
            // Cek apakah sudah ada portofolio
            $portofolio = Portofolio::firstOrNew([
                'worker_id' => $workerProfile->id,
                'title' => $request->title,
            ]);

            // Update portofolio data
            $portofolio->description = $request->description ?? $portofolio->description;
            $portofolio->duration = $request->duration ?? $portofolio->duration;
            $portofolio->save();

            // Upload gambar portofolio baru
            foreach ($request->file('portofolio') as $file) {
                $portoImagePath = $file->store('portofolio', 'public');

                PortofolioImage::create([
                    'portofolio_id' => $portofolio->id,
                    'image' => $portoImagePath,
                ]);
            }
        }
        

        return redirect()->route('profil')->with('success', 'Anda telah berhasil menyimpan.');
    }



    public function updateProfileImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user = Auth::user();

        // Hapus gambar lama jika ada
        if ($user->profile_image) {
            Storage::delete('public/' . $user->profile_image);
        }

        // Simpan gambar baru
        $imagePath = $request->file('profile_image')->store('profile_images', 'public');
        $user->profile_image = $imagePath;
        $user->save();

        return response()->json(['success' => true, 'image_url' => asset('storage/' . $imagePath)]);
    }

}
