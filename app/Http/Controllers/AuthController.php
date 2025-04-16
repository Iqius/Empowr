<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\UserPaymentAccount;



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
                return redirect()->route('worker.dashboardWorker')->with('success', 'Login berhasil!');
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

    // **LOGOUT**
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'Anda telah logout.');
    }   

}