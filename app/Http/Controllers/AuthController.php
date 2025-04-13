<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPaymentAccount;
use App\Models\WorkerProfile;
use App\Models\Sertifikasi;
use App\Models\SertifikasiImage;
use App\Models\Portofolio;
use App\Models\PortofolioImage;

class AuthController extends Controller
{
    // **REGISTER**
    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:client,worker',
            'nomor_telepon' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'nama_lengkap' => $request->nama_lengkap,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'nomor_telepon' => $request->nomor_telepon,
            'tanggal_bergabung' => now(),
            'password' => Hash::make($request->password),
        ]);

        if ($request->role == 'worker') {
            WorkerProfile::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('register')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // **LOGIN**
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean',
        ]);

        $credentials = $request->only('username', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'client') {
                return redirect()->route('client.dashboardClient')->with('success', 'Login berhasil!');
            } elseif ($user->role === 'worker') {
                return redirect()->route('client.dashboardClient')->with('success', 'Login berhasil!');
            }

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah.');
    }

    public function clientDashboard()
    {
        // if (!Auth::check() || Auth::user()->role !== 'client') {
        //     return redirect('/worker/dashboard')->with('error', 'Access Denied!');
        // }

        return view('client.dashboardClient'); 
    }

    public function clientNew()
    {
        if (!Auth::check() || Auth::user()->role !== 'client') {
            return redirect('/worker/dashboard')->with('error', 'Access Denied!');
        }

        return view('new'); 
    }

    public function workerDashboard()
    {
        return view('dashboardWorker'); 
    }

    public function workerJobs()
    {
        return view('jobs'); 
    }

    // **LOGOUT**
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

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

        // Update atau buat data pembayaran
        UserPaymentAccount::updateOrCreate(
            ['user_id' => $user->id],
            [
                'account_type' => $request->account_type,
                'wallet_number' => $request->wallet_number,
                'ewallet_name' => $request->ewallet_name,
                'bank_name' => $request->bank_name,
                'bank_number' => $request->bank_number,
                'pemilik_bank' => $request->pemilik_bank,
                'ewallet_provider' => $request->ewallet_provider,
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

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function showProfile()
    {
        $user = Auth::user();
        $workerProfile = $user->workerProfile;

        $sertifikasi = Sertifikasi::with('images')->where('worker_id', $user->id)->get();
        $portofolio = Portofolio::with('images')->where('worker_id', $user->id)->get();

        return view('profil', compact('workerProfile', 'sertifikasi', 'portofolio'));
    }

}
