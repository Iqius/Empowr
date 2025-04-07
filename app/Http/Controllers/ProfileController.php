<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\UserPaymentAccount;
use App\Models\Portfolio;

class ProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();
        return view('client.showprofile', compact('user'));
    }

    // public function update(Request $request)
    // {


    //     $request->validate([
    //         // 'nama_lengkap' => 'required|string|max:255',
    //         // 'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
    //         // 'nomor_telepon' => 'nullable|string|max:20',
    //         // 'alamat' => 'nullable|string|max:255',
    //         // 'negara' => 'nullable|string|max:100',
    //         // 'bio' => 'nullable|string',
    //         'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    //         'password' => 'nullable|string|min:6|confirmed',
    //         'account_type' => 'nullable|in:bank,paypal,e-wallet',
    //         'account_number' => 'nullable|string|max:50',
    //         'account_name' => 'nullable|string|max:100',
    //         'bank_name' => 'nullable|string|max:100',
    //         'ewallet_provider' => 'nullable|string|max:100',
    //     ]);

    //     $user = Auth::user();

    //     $user->nama_lengkap = $request->nama_lengkap;
    //     $user->email = $request->email;
    //     $user->nomor_telepon = $request->nomor_telepon;
    //     $user->alamat = $request->alamat;
    //     $user->negara = $request->negara;
    //     $user->bio = $request->bio;
    //     $user->save();
        

    //     // Update atau buat data pembayaran
    //     UserPaymentAccount::updateOrCreate(
    //         ['user_id' => $user->id],
    //         [
    //             'account_type' => $request->account_type,
    //             'account_number' => $request->account_number,
    //             'account_name' => $request->account_name,
    //             'bank_name' => $request->bank_name,
    //             'ewallet_provider' => $request->ewallet_provider,
    //         ]
    //     );

    //     return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    // }

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
