<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Ewallet;
use App\Models\Transaction;
use App\Models\UserPaymentAccount;
use App\Models\workerAffiliated;

class paymentController extends Controller
{

    // Ngirim data pembayaran ke midtrans
    public function bayar(Request $request, Task $task = null)
    {
        try {
            Config::$serverKey = config('midtrans.server_key');
            Config::$isProduction = false;
            Config::$isSanitized = true;
            Config::$is3ds = true;

            // Ambil data dari request
            $amount = $request->amount;
            $paymentMethod = $request->input('payment_method');
            $type = $request->input('type'); 

            // Untuk payment type 'payment', harus ada task dan worker_profile_id
            if ($type === 'payment') {
                $id = $request->id_order;
                $workerProfileId = $request->worker_profile_id;

                $task = Task::findOrFail($id);
                $client = User::findOrFail($task->client_id);

                $workerId = $workerProfileId; // sesuaikan jika perlu cari worker id

                $uniqueOrderId = $id . '-' . $workerProfileId . '-' . time();

                $transaction = Transaction::create([
                    'order_id' => $uniqueOrderId,
                    'task_id' => $id,
                    'worker_id' => $workerId,
                    'client_id' => $client->id,
                    'amount' => $amount,
                    'status' => 'pending',
                    'type' => 'payment',
                    'payment_method' => $paymentMethod,
                ]);
                

                // Customer details dari client
                $customer = [
                    'first_name' => $client->nama_lengkap,
                    'last_name' => '',
                    'email' => $client->email,
                    'phone' => $client->nomor_telepon,
                ];

            } elseif ($type === 'topup') {
                $clientId = $request->input('client_id'); // boleh null
                $workerId = $request->input('worker_id'); // boleh null

                if (!$clientId && !$workerId) {
                    return back()->with('error', 'Topup harus ditujukan ke client atau worker.');
                }

                // Generate order id unik
                $uniqueOrderId = 'topup-' . ($clientId ?? $workerId) . '-' . time();

                $transaction = Transaction::create([
                    'order_id' => $uniqueOrderId,
                    'task_id' => null,
                    'worker_id' => $workerId,
                    'client_id' => $clientId,
                    'amount' => $amount,
                    'status' => 'pending',
                    'type' => 'topup',
                ]);

                

                // Cari data customer agar bisa kirim ke Midtrans
                if ($clientId) {
                    $user = User::findOrFail($clientId);
                } elseif ($workerId) {
                    $workerProfile = WorkerProfile::findOrFail($workerId);
                    $user = $workerProfile->user;  // Ini akan ngambil data user terkait
                }

                $customer = [
                    'first_name' => $user->nama_lengkap ?? $user->name ?? 'User',
                    'last_name' => '',
                    'email' => $user->email ?? 'user@example.com',
                    'phone' => $user->nomor_telepon ?? '08123456789',
                ];
            } else {
                return back()->with('error', 'Tipe pembayaran tidak valid.');
            }

            // Set parameter Midtrans
            $params = [
                'transaction_details' => [
                    'order_id' => $uniqueOrderId,
                    'gross_amount' => $amount,
                ],
                'customer_details' => $customer,
            ];

            $snapToken = Snap::getSnapToken($params);

            return back()->with([
                'snap_token' => $snapToken,
                'order_id' => $uniqueOrderId,
                'amount' => $amount,
            ]);

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();

            if (strpos($errorMessage, 'order_id sudah digunakan') !== false) {
                return back()->with('error', 'Order ID sudah digunakan. Silakan coba lagi.');
            }

            return back()->with('error', 'Terjadi kesalahan: ' . $errorMessage);
        }
    }


    // Callback untuk midtrans
    public function callback(Request $request)
    {
        $serverKey = config('midtrans.server_key');
        $hash = hash('sha512', $request->order_id . $request->status_code . $request->gross_amount . $serverKey);

        if ($hash !== $request->signature_key) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        $transaction = Transaction::where('order_id', $request->order_id)->first();

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        if ($request->transaction_status === 'capture' || $request->transaction_status === 'settlement') {
            if ($transaction->status !== 'success') {
                $transaction->status = 'success';
                $transaction->save();

                if ($transaction->type === 'payment') {
                    $task = $transaction->task;
                    if ($task) {
                        $hasAffiliate = TaskApplication::where('task_id', $task->id)
                            ->where('affiliated', true)
                            ->exists();

                        // Kalau ada affiliated = true, update task dengan informasi khusus affiliate (opsional)
                        if ($hasAffiliate) {
                            $task->status = 'in progress'; // atau bisa disesuaikan
                            $task->profile_id = $transaction->worker_id;
                            $task->client_id = $transaction->client_id;
                            $task->status_affiliate = true;
                            $task->price = $transaction->amount;
                            $task->save();

                            TaskReview::create([
                                'task_id' => $task->id,
                                'user_id' => $transaction->worker_id, // User yang memberikan ulasan (client)
                                'reviewed_user_id' => $transaction->client_id, // Worker yang menerima ulasan
                                'rating' => '0', // Rating
                                'comment' => null, // Komentar
                            ]);

                            TaskReview::create([
                                'task_id' => $task->id,
                                'user_id' => $transaction->client_id, // User yang memberikan ulasan (client)
                                'reviewed_user_id' => $transaction->worker_id, // Worker yang menerima ulasan
                                'rating' => '0', // Rating
                                'comment' => null, // Komentar
                            ]);
                        } else {
                            // Kalau bukan affiliate
                            $task->price = $transaction->amount;
                            $task->profile_id = $transaction->worker_id;
                            $task->client_id = $transaction->client_id;
                            $task->status_affiliate = false;
                            $task->status = 'in progress';
                            $task->save();

                            TaskReview::create([
                                'task_id' => $task->id,
                                'user_id' => $transaction->worker_id, // User yang memberikan ulasan (client)
                                'reviewed_user_id' => $transaction->client_id, // Worker yang menerima ulasan
                                'rating' => '0', // Rating
                                'comment' => null, // Komentar
                            ]);

                            TaskReview::create([
                                'task_id' => $task->id,
                                'user_id' => $transaction->client_id, // User yang memberikan ulasan (client)
                                'reviewed_user_id' => $transaction->worker_id, // Worker yang menerima ulasan
                                'rating' => '0', // Rating
                                'comment' => null, // Komentar
                            ]);
                        }
                        // Bisa juga skip penghapusan task application kalau dibutuhkan
                        TaskApplication::where('task_id', $task->id)->delete();
                    }
                } elseif ($transaction->type === 'topup') {
                    $userId = $transaction->client_id ?? $transaction->worker_id;

                    $ewalet = Ewallet::where('user_id', $userId)->first();
                    if ($ewalet) {
                        $ewalet->balance += $transaction->amount;
                        $ewalet->save();
                    } else {
                        Ewallet::create([
                            'user_id' => $userId,
                            'balance' => $transaction->amount,
                        ]);
                    }
                }
            }
        } elseif ($request->transaction_status === 'pending') {
            $transaction->status = 'pending';
            $transaction->save();
        } elseif ($request->transaction_status === 'cancel' || $request->transaction_status === 'expire') {
            $transaction->status = $request->transaction_status;
            $transaction->save();
        }

        return response()->json(['success' => true]);
    }


    public function ewalletIndex()
    {
        $userId = Auth::id();

        $ewallet = Ewallet::where('user_id', $userId)->first();

        $paymentAccounts = UserPaymentAccount::where('user_id', $userId)->first();

        $transactions = Transaction::where('worker_id', $userId)
                        ->orWhere('client_id', $userId)
                        ->orderBy('created_at', 'desc')
                        ->get();

        return view('General.ewallet', compact('ewallet', 'paymentAccounts', 'transactions'));
    }


    // Pembayaran menggunakan ewallet
    public function bayarEwalletBase(Request $request)
    {
        // Ambil user yang login
        $user = auth()->user();
        $taskId = $request->input('task_id');
        $task = Task::find($taskId);
        // Ambil data yang diperlukan
        $amount = $request->amount ?? $task->price;
        $paymentMethod = $request->input('payment_method');
        $type = $request->input('type');
        $workerId = $request->worker_profile_id ?? $task->profile_id;
        
        
        // Ambil ewallet user
        $ewallet = Ewallet::where('user_id', $user->id)->first();

        if (!$ewallet) {
            return back()->with('error', 'Ewallet tidak ditemukan.');
        }

        // Cek saldo cukup
        if ($ewallet->balance < $amount) {
            return back()->with('error', 'Saldo tidak mencukupi.');
        }

        $hasAffiliate = TaskApplication::where('task_id', $task->id)
            ->where('affiliated', true)
            ->exists();

        if ($hasAffiliate) {
            // Potong saldo ewallet
            $ewallet->balance -= $amount;
            $ewallet->save();

            $task->update([
                'price' => $amount,
                'profile_id' => $workerId,
                'client_id' => $user->id,
                'status_affiliate' => true,
                'status' => 'in progress',
            ]);

            // Untuk ratting otomatis kebuat ketika hire
            TaskReview::create([
                'task_id' => $task->id,
                'user_id' => $workerId, // User yang memberikan ulasan (client)
                'reviewed_user_id' => $user->id, // Worker yang menerima ulasan
                'rating' => '0', // Rating
                'comment' => null, // Komentar
            ]);

            TaskReview::create([
                'task_id' => $task->id,
                'user_id' => $user->id, // User yang memberikan ulasan (client)
                'reviewed_user_id' => $workerId, // Worker yang menerima ulasan
                'rating' => '0', // Rating
                'comment' => null, // Komentar
            ]);
        } else {
            // Potong saldo ewallet
            $ewallet->balance -= $amount;
            $ewallet->save();

            $task->update([
                'price' => $amount,
                'profile_id' => $workerId,
                'client_id' => $user->id,
                'status_affiliate' => false,
                'status' => 'in progress',
            ]);


            // Untuk ratting otomatis kebuat ketika hire
            TaskReview::create([
                'task_id' => $task->id,
                'user_id' => $workerId, // User yang memberikan ulasan (client)
                'reviewed_user_id' => $user->id, // Worker yang menerima ulasan
                'rating' => '0', // Rating
                'comment' => null, // Komentar
            ]);

            TaskReview::create([
                'task_id' => $task->id,
                'user_id' => $user->id, // User yang memberikan ulasan (client)
                'reviewed_user_id' => $workerId, // Worker yang menerima ulasan
                'rating' => '0', // Rating
                'comment' => null, // Komentar
            ]);
        }
        
        // Hapus semua aplikasi task
        TaskApplication::where('task_id', $task->id)->delete();
        
        // Buat unique order ID dan transaksi pembayaran
        $uniqueOrderId = $taskId . '-' . $workerId . '-' . time();
        
        Transaction::create([
            'order_id' => $uniqueOrderId,
            'task_id' => $taskId,
            'worker_id' => $workerId,
            'client_id' => $user->id,
            'amount' => $amount,
            'status' => 'success',
            'type' => $type,
            'payment_method' => $paymentMethod,
        ]);

        return redirect()->route('jobs.my')->with('success', 'Pembayaran berhasil menggunakan e-wallet.');
    }



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
