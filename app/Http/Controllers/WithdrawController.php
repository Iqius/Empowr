<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ewallet;
use App\Models\Transaction;
use App\Models\UserPaymentAccount;
use App\Models\workerAffiliated;

class WithdrawController extends Controller
{
    public function pencairanDana(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'withdraw_method' => 'required|in:bank,ewallet',
        ]);

        $user = Auth::user();
     

        // Ambil ewallet user (bisa worker atau client)
        $ewallet = Ewallet::where('user_id', $user->id)->first();
       

        // Cek saldo ewallet
        if (!$ewallet || $ewallet->balance < $request->amount) {
            return back()->with('error', 'Saldo e-wallet tidak mencukupi.');
        }

        // Kurangi saldo ewallet
        $ewallet->balance -= $request->amount;
        $ewallet->save();

        // Buat transaksi withdraw
        $transactionData = [
            'order_id' => 'WD-' . strtoupper(uniqid()),
            'amount' => $request->amount,
            'status' => 'pending',
            'type' => 'payout',
            'withdraw_method' => $request->withdraw_method, // 'bank' atau 'ewallet'
        ];

       

        // Tentukan role pengguna
        if ($user->role === 'worker') {
            $transactionData['worker_id'] = $user->id;
        } elseif ($user->role === 'client') {
            $transactionData['client_id'] = $user->id;
        }

        Transaction::create($transactionData);

        return back()->with('success', 'Permintaan penarikan berhasil dikirim. Menunggu persetujuan admin.');
    }


    // Admin list payment
    public function indexWithdraw(){
        $withdrawals = Transaction::with(['worker', 'client'])
            ->where('type', 'payout')
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();


        return view('admin.Withdraw.withdrawListUser', compact('withdrawals'));
    }

    // untuk mengganti status sudah dikirimkan
    public function approveWithdraw(Request $request, $id)
    {
        $withdraw = Transaction::findOrFail($id);

        // Validasi input
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Simpan bukti transfer
        if ($request->hasFile('bukti_transfer')) {
            $file = $request->file('bukti_transfer');
            $filename = 'bukti_transfer_' . time() . '.' . $file->getClientOriginalExtension();
            $filePath = $file->storeAs('bukti_transfer', $filename, 'public');
            $withdraw->proof_transfer = $filePath;
        }

        $withdraw->status = 'success';
        $withdraw->save();

       return redirect()->route('withdraw.view')->with('success', 'Withdraw disetujui dan bukti transfer berhasil diunggah.');
    }

    public function rejectWithdraw($id)
    {
        $withdraw = Transaction::findOrFail($id);

        // Ambil e-wallet pemilik dana
        $ewallet = null;

        if ($withdraw->worker && $withdraw->worker->user) {
            $ewallet = $withdraw->worker->user->Ewallet;
        } elseif ($withdraw->client && $withdraw->client->user) {
            $ewallet = $withdraw->client->Ewallet;
        }

        

        // Cek apakah e-wallet ditemukan
        if (!$ewallet) {
            return redirect()->back()->with('error', 'E-wallet tidak ditemukan atau belum dibuat.');
        }

        // Tambahkan saldo dan simpan
        $ewallet->balance += $withdraw->amount;
        $ewallet->save();

        // Ubah status withdraw
        $withdraw->status = 'cancel';
        $withdraw->save();

        return redirect()->route('withdraw.view')->with('success', 'Withdraw berhasil ditolak dan dana dikembalikan.');
    }
}
