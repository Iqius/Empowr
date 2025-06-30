<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ewallet;
use App\Models\Transaction;
use App\Models\UserPaymentAccount;
use App\Models\WorkerAffiliated;
use App\Models\Task;
use App\Models\TaskReview;
use Illuminate\Support\Collection;

class WithdrawController extends Controller
{
    public function pencairanDana(Request $request){
        $request->validate([
            'amount' => 'required|numeric|min:10000',
            'withdraw_method' => 'required|in:bank,ewallet',
        ]);

        $user = Auth::user();
        $workerId = $user->workerProfile->id;
        
        if ($user->role == 'worker') {
            

            // Ambil semua task yang sudah selesai
            $completedTaskIds = Task::where('profile_id', $workerId)
                ->where('status', 'completed')
                ->pluck('id');

            // Ambil semua ID task yang sudah direview oleh user ini
            $reviewedTaskIds = TaskReview::where('user_id', $user->id)
                ->whereIn('task_id', $completedTaskIds)
                ->pluck('task_id');

            // Ambil task ID yang belum direview
            $unreviewedCompletedTaskIds = $completedTaskIds->diff($reviewedTaskIds);

            // Ambil data task dari ID tersebut
            $unratedTasks = collect();
            if ($unreviewedCompletedTaskIds->isNotEmpty()) {
                $unratedTasks = Task::whereIn('id', $unreviewedCompletedTaskIds)->get();
            }

            if ($unratedTasks->isNotEmpty()) {
                return back()->with([
                    'show_unrated_modal' => true,
                    'unrated_tasks' => $unratedTasks
                ]);
            }
        }else{
            $completedTaskIds = Task::where('profile_id', $user->id)
                                ->where('status', 'completed')
                                ->pluck('id');        
            $reviewedTaskIds = TaskReview::where('user_id', $user->id)
                                        ->whereIn('task_id', $completedTaskIds)
                                        ->pluck('task_id');
            $unreviewedCompletedTaskIds = $completedTaskIds->diff($reviewedTaskIds);
            $unratedTasks = [];
            if ($unreviewedCompletedTaskIds->isNotEmpty()) {
                $unratedTasks = Task::whereIn('id', $unreviewedCompletedTaskIds)->get();
            }
            if ($unratedTasks->count() > 0) {
                return back()->with([
                    'show_unrated_modal' => true,
                    'unrated_tasks' => $unratedTasks
                ]);
            }
        }
        

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
            $transactionData['worker_id'] = $workerId;
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
