<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPaymentAccount;
use App\Models\WorkerProfile;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Carbon;
use App\Models\OtpCode;
use App\Models\Ewallet;



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
        
        Ewallet::create([
            'user_id' => $user->id,
            'balance' => 0.00,
        ]);

        if ($request->role == 'worker') {
            WorkerProfile::create([
                'user_id' => $user->id,
            ]);
            UserPaymentAccount::create([
                'user_id' => $user->id,
            ]);
        }else{
            UserPaymentAccount::create([
                'user_id' => $user->id,
            ]);
        }

        return redirect()->route('register')->with('success', 'Akun berhasil dibuat! Silakan login.');
    }

    // **LOGIN**
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->remember)) {
            $user = Auth::user();

            // Redirect berdasarkan role
            if ($user->role === 'client') {
                return redirect()->route('client.dashboardClient')->with('success', 'Login berhasil!');
            } elseif ($user->role === 'worker') {
                return redirect()->route('worker.dashboardWorker')->with('success', 'Login berhasil!');
            } elseif($user->role === 'admin'){
                return redirect()->route('admin.dashboardAdmin')->with('success', 'Login berhasil!');
            }

            return redirect()->route('dashboard')->with('success', 'Login berhasil!');
        }

        return back()->with('error', 'Username atau password salah.');
    }


    // Dashboard Client view
    public function clientDashboard()
    {
        if(Auth::user()->role == 'client'){
            return view('client.dashboardClient');
        }
        return view('Landing.landing');
         
    }

    // Dashboard Worker view
    public function workerDashboard()
    {
        if(Auth::user()->role == 'worker'){
            return view('worker.dashboardWorker');
        }
        return view('Landing.landing'); 
    }


    public function adminDashboard()
    {
        if(Auth::user()->role == 'admin'){
            return view('admin.dashboardAdmin');
        }
        return view('Landing.landing'); 
    }


    // **LOGOUT**
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }   




    // FORGOT PASS SECTION
    //  Menampilkan form lupa password
    public function showForgotForm()
    {
        return view('auth.forgot-password');
    }


    //  Mengirim OTP ke email
    public function sendOtp(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $otp = rand(100000, 999999);
        $expiresAt = Carbon::now()->addMinutes(10);

        OtpCode::updateOrCreate(
            ['email' => $request->email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        $message = "Halo,

        Berikut adalah kode OTP Anda: $otp

        Kode ini hanya berlaku selama 10 menit. Mohon JANGAN BERBAGI kode ini kepada siapa pun, termasuk pihak yang mengaku dari Empowr.

        Jika Anda tidak melakukan permintaan ini, harap abaikan email ini.

        Salam hangat,
        Tim Keamanan Empowr";
        
        // Kirim OTP via email
        Mail::raw($message, function ($msg) use ($request) {
            $msg->to($request->email)->subject('Kode OTP Verifikasi - Empowr');
        });

        session(['email' => $request->email]);

        return redirect()->route('forgot-password.otp-form')->with('success', 'OTP telah dikirim ke email Anda.');
    }


    //  Menampilkan form verifikasi OTP (6 kotak)
    public function showOtpForm()
    {
        return view('auth.verify-otp');
    }

    //  Proses verifikasi OTP (hanya cek, belum reset password)
    public function checkOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp' => 'required|array|size:6',
            'otp.*' => 'required|numeric|digits:1',
        ]);

        $otp = implode('', $request->otp); // Gabungkan array menjadi '123456'

        $otpRecord = OtpCode::where('email', $request->email)
            ->where('otp', $otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->withErrors(['otp' => 'OTP salah atau sudah kedaluwarsa.']);
        }

        // Simpan status verifikasi
        session(['otp_verified' => true]);

        return redirect()->route('forgot-password.set-password-form');
    }

    //  Tampilkan form set password baru
    public function showSetPasswordForm()
    {
        if (!session('otp_verified')) {
            return redirect()->route('forgot-password.form')->withErrors(['otp' => 'Harap verifikasi OTP terlebih dahulu.']);
        }

        return view('auth.set-password');
    }

    //  Simpan password baru
    public function setNewPassword(Request $request)
    {
        if (!session('otp_verified')) {
            return redirect()->route('forgot-password.form')->withErrors(['otp' => 'Harap verifikasi OTP terlebih dahulu.']);
        }

        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        OtpCode::where('email', $request->email)->delete();
        session()->forget(['otp_verified', 'email']);

        return redirect()->route('login')->with('success', 'Password berhasil direset. Silakan login.');
    }
    //resend otp
    public function resendOtp(Request $request)
    {
        $email = session('email');

        if (!$email) {
            return redirect()->route('forgot-password.form')->with('error', 'Email tidak ditemukan di sesi.');
        }

        $otp = rand(100000, 999999);
        $expiresAt = now()->addMinutes(10);

        OtpCode::updateOrCreate(
            ['email' => $email],
            ['otp' => $otp, 'expires_at' => $expiresAt]
        );

        Mail::raw("Kode OTP Baru Anda: $otp", function ($msg) use ($email) {
            $msg->to($email)->subject('Resend OTP');
        });

        return back()->with('success', 'Kode OTP baru telah dikirim.');
    }
}