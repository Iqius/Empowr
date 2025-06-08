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
use App\Models\workerAffiliated;



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
        // Kalau user sudah login, langsung redirect
        if (Auth::check()) {
            $user = Auth::user();

            // Cek dan set session custom jika belum ada
            if (!session()->has('user_data')) {
                session()->put('user_data', [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'email' => $user->email,
                ]);
            }

            return match ($user->role) {
                'client' => redirect()->route('client.dashboardClient'),
                'worker' => redirect()->route('worker.dashboardWorker'),
                'admin'  => redirect()->route('admin.dashboardAdmin'),
                default  => redirect()->route('dashboard'),
            };
        }

        // Validasi form login
        $request->validate([
            'email' => 'required|string',
            'password' => 'required|string',
            'remember' => 'sometimes|boolean',
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $user = Auth::user();

            // Simpan session custom jika belum ada
            if (!session()->has('user_data')) {
                session()->put('user_data', [
                    'id' => $user->id,
                    'name' => $user->name,
                    'role' => $user->role,
                    'email' => $user->email,
                ]);
            }

            return match ($user->role) {
                'client' => redirect()->route('client.dashboardClient')->with('success', 'Login berhasil!'),
                'worker' => redirect()->route('worker.dashboardWorker')->with('success', 'Login berhasil!'),
                'admin'  => redirect()->route('admin.dashboardAdmin')->with('success', 'Login berhasil!'),
                default  => redirect()->route('dashboard')->with('success', 'Login berhasil!'),
            };
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
            $worker = Auth::user();
            $workerProfile = $worker->workerProfile;

            $affiliation = null;
            $hasAffiliation = false;
            if ($workerProfile) {
                $affiliation = workerAffiliated::where('profile_id', $workerProfile->id)->first();
                if ($affiliation) {
                    $hasAffiliation = true;
                    $affiliation = $affiliation->id; 
                }
            }
            return view('worker.dashboardWorker', compact('workerProfile', 'hasAffiliation', 'affiliation'));
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
}