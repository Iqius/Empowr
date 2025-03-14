<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    // **REGISTER**
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'role' => 'required|in:client,worker',
            'date' => 'nullable|date',
            'phone' => 'nullable|string|max:15',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'role' => $request->role,
            'date' => $request->date,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('login')->with('success', 'Akun berhasil dibuat! Silakan login.');
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

    public function clientDashboard()
    {
        // if (!Auth::check() || Auth::user()->role !== 'client') {
        //     return redirect('/worker/dashboard')->with('error', 'Access Denied!');
        // }

        return view('dashboardClient'); 
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
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:15',
            'linkedin' => 'nullable|url',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Maks 2MB
        ]);

        $user = Auth::user();

        // Handle Upload Gambar
        if ($request->hasFile('profile_image')) {
            $imagePath = $request->file('profile_image')->store('profile_images', 'public');
            $user->profile_image = $imagePath;
        }

        $user->name = $request->name;
        $user->phone = $request->phone;
        $user->linkedin = $request->linkedin;
        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

}
