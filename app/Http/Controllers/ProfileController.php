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

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();
        $workerProfile = $user->workerProfile;

        $sertifikasi = Sertifikasi::with('images')->where('worker_id', $user->id)->get();
        $portofolio = Portofolio::with('images')->where('worker_id', $user->id)->get();
        
        return view('General.profil', compact('workerProfile', 'sertifikasi', 'portofolio'));
    }


    public function showProfileWorkerLamar($id)
    {
        // Ambil worker beserta relasi user
        $worker = WorkerProfile::with(['user', 'certifications.images'])->findOrFail($id);
        return view('client.Jobs.lamaranWorkerDetailProfile', compact('worker'));
    }

    // Update profile
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string',
            'alamat' => 'nullable|string',
            'negara' => 'nullable|string',
            'bio' => 'nullable|string',
            'keahlian' => 'nullable|array',
            'tingkat_keahlian' => 'nullable|string',
            'pengalaman_kerja' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240', // 10MB
            'sertifikat' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'sertifikat_caption' => 'nullable|string',
            'portofolio' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'portofolio_caption' => 'nullable|string',
            'account_type' => 'nullable|string',
            'wallet_number' => 'nullable|string',
            'ewallet_name' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'bank_number' => 'nullable|string',
            'pemilik_bank' => 'nullable|string',
            'ewallet_provider' => 'nullable|string',
        ]);


        // Update data user
        $user->nama_lengkap = $request->nama_lengkap ?? $user->nama_lengkap;
        $user->email = $request->email ?? $user->email;
        $user->nomor_telepon = $request->nomor_telepon ?? $user->nomor_telepon;
        $user->alamat = $request->alamat ?? $user->alamat;
        $user->negara = $request->negara ?? $user->negara;
        $user->bio = $request->bio ?? $user->bio;
        $user->save();

        // Update khusus role worker
        // Update data user
        $user->nama_lengkap = $request->nama_lengkap;
        $user->email = $request->email;
        $user->nomor_telepon = $request->nomor_telepon;
        $user->alamat = $request->alamat;
        $user->negara = $request->negara;
        $user->bio = $request->bio;
        $user->save();

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

        // Update path CV kalau file baru di-upload
        $workerProfile->cv = $request->file('cv')
            ? $request->file('cv')->store('cv', 'public')
            : $workerProfile->cv; // jaga path lama kalau gak upload

        // Simpan data lain
        $workerProfile->keahlian = json_encode($request->keahlian);
        $workerProfile->tingkat_keahlian = $request->tingkat_keahlian;
        $workerProfile->pengalaman_kerja = $request->pengalaman_kerja;
        $workerProfile->pendidikan = $request->pendidikan;
        $workerProfile->empowr_label = $request->has('empowr_label');
        $workerProfile->empowr_affiliate = $request->has('empowr_affiliate');

        // Simpan semuanya
        $workerProfile->save();

        // Data rekening tetap bisa diisi semua role
        UserPaymentAccount::updateOrCreate(
            ['user_id' => $user->id],
            [
                'account_type' => $request->account_type,
                'wallet_number' => $request->wallet_number,
                'ewallet_provider' => $request->ewallet_name,
                'bank_name' => $request->bank_name,
                'account_number' => $request->bank_number,
                'account_name' => $request->pemilik_bank,
            ]
        );

        // Upload Sertifikat
        if ($request->hasFile('sertifikat')) {
            $sertifikasi = Sertifikasi::create([
                'worker_id' => $user->id,
                'title' => $request->sertifikat_caption,
            ]);

            $sertifImage = $request->file('sertifikat')->store('sertifikasi', 'public');

            SertifikasiImage::create([
                'sertifikasi_id' => $sertifikasi->id,
                'image' => $sertifImage,
            ]);
        }

        // Upload Portofolio
        if ($request->hasFile('portofolio')) {
            $portofolio = Portofolio::create([
                'worker_id' => $user->id,
                'title' => $request->portofolio_caption,
                'description' => '',
                'duration' => 0,
            ]);

            $portoImage = $request->file('portofolio')->store('portofolio', 'public');

            PortofolioImage::create([
                'portfolio_id' => $portofolio->id,
                'image' => $portoImage,
            ]);
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
