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
use App\Models\WorkerAffiliated;
use App\Models\task;
use App\Models\TaskReview;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function showProfile()
    {
        $user = Auth::user();

        if ($user->role === 'client') {
            $tasks = Task::with('review')
                ->where('client_id', $user->id)
                ->where('status', 'completed')
                ->latest()
                ->get();

            $ratingData = TaskReview::where('reviewed_user_id', $user->id)
                ->whereNotNull('rating')
                ->get();

            $avgRating = $ratingData->avg('rating') ?? 0;
            $countReviews = $ratingData->count();

            $breakdown = collect([5, 4, 3, 2, 1])->mapWithKeys(function ($star) use ($ratingData, $countReviews) {
                $count = $ratingData->where('rating', $star)->count();
                $percentage = $countReviews > 0 ? round(($count / $countReviews) * 100) : 0;

                return [$star => [
                    'count' => $count,
                    'percentage' => $percentage,
                ]];
            });

            return view('General.profil', [
                'workerProfile' => null,
                'sertifikasi' => collect(),
                'portofolio' => collect(),
                'tasks' => $tasks,
                'ratingData' => $ratingData,
                'avgRating' => $avgRating,
                'countReviews' => $countReviews,
                'breakdown' => $breakdown,
            ]);
        }



        $workerProfile = $user->workerProfile;

        $sertifikasi = Sertifikasi::with('images')->where('worker_id', $workerProfile->id)->get();
        $portofolio = Portofolio::with('images')->where('worker_id', $workerProfile->id)->get();
        $tasks = Task::with('review')
            ->where('profile_id', $workerProfile->id)
            ->where('status', 'completed')
            ->latest()
            ->get();

        $ratingData = TaskReview::with('user')
            ->where('reviewed_user_id', $user->id)
            ->get();

        $avgRating = $ratingData->avg('rating') ?? 0;
        $countReviews = $ratingData->count();
        $breakdown = collect([5, 4, 3, 2, 1])->mapWithKeys(function ($star) use ($ratingData, $countReviews) {
            $count = $ratingData->where('rating', $star)->count();
            $percentage = $countReviews > 0 ? round(($count / $countReviews) * 100) : 0;

            return [$star => [
                'count' => $count,
                'percentage' => $percentage,
            ]];
        });
        return view('General.profil', compact('workerProfile', 'sertifikasi', 'portofolio', 'tasks', 'ratingData', 'avgRating', 'countReviews', 'breakdown'));
    }




    public function showProfileWorkerLamar($id)
    {
        // Ambil worker beserta relasi user
        $worker = WorkerProfile::with(['user', 'certifications.images'])->findOrFail($id);

        $data = WorkerAffiliated::where('profile_id', $worker->id)->get();
        return view('General.lamaranWorkerDetailProfile', compact('worker', 'data'));
    }

    public function updateDataDiri(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string',
            'bio' => 'nullable|string',
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'keahlian' => 'nullable|array',
            'keahlian.*' => 'string|max:255',
            'cv' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240',
            'linkedin' => 'nullable|string',
        ]);

        $user->nama_lengkap = $request->nama_lengkap ?? $user->nama_lengkap;
        $user->email = $request->email ?? $user->email;
        $user->nomor_telepon = $request->nomor_telepon ?? $user->nomor_telepon;
        $user->bio = $request->input('bio');

        if ($request->hasFile('profile_image')) {
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }
            $user->profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->save();

        // Hanya update data ini jika user adalah worker
        if ($user->role === 'worker') {
            $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

            if ($request->hasFile('cv')) {
                $workerProfile->cv = $request->file('cv')->store('cv', 'public');
            }

            $workerProfile->keahlian = $request->keahlian ? json_encode($request->keahlian) : $workerProfile->keahlian;
            $workerProfile->linkedin = $request->linkedin ?? $workerProfile->linkedin;
            $workerProfile->empowr_label = $request->has('empowr_label');
            $workerProfile->empowr_affiliate = $request->has('empowr_affiliate');
            $workerProfile->save();
        }

        return redirect()->route('profil')->with('success-update', 'Data diri berhasil diperbarui.');
    }


    public function updatePaymentAccount(Request $request)
    {
        $request->validate([
            'wallet_number' => 'nullable|string',
            'ewallet_account_name' => 'nullable|string',
            'ewallet_provider' => 'nullable|string',

            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'bank_account_name' => 'nullable|string',
        ]);

        $user = Auth::user();

        $account = UserPaymentAccount::firstOrNew(['user_id' => $user->id]);

        $account->wallet_number = $request->wallet_number ?? $account->wallet_number;
        $account->ewallet_provider = $request->ewallet_provider ?? $account->ewallet_provider;
        $account->ewallet_account_name = $request->ewallet_account_name ?? $account->ewallet_account_name;

        $account->bank_name = $request->bank_name ?? $account->bank_name;
        $account->account_number = $request->account_number ?? $account->account_number;
        $account->bank_account_name = $request->bank_account_name ?? $account->bank_account_name;


        $account->save();

        return redirect()->route('profil')->with('success-update', 'Akun pembayaran berhasil diperbarui.');
    }


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string',
            'bio' => 'nullable|string',

            // ubah menjadi tidak required
            'profile_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            'keahlian' => 'nullable|array',
            'keahlian.*' => 'string|max:255',

            'cv' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240',

            'wallet_number' => 'nullable|string',
            'ewallet_account_name' => 'nullable|string',
            'ewallet_provider' => 'nullable|string',
            'bank_name' => 'nullable|string',
            'account_number' => 'nullable|string',
            'bank_account_name' => 'nullable|string',
        ]);

        $user->nama_lengkap = $request->nama_lengkap ?? $user->nama_lengkap;
        $user->email = $request->email ?? $user->email;
        $user->nomor_telepon = $request->nomor_telepon ?? $user->nomor_telepon;
        $user->bio = $request->input('bio');

        // ✅ Update Profile Image
        if ($request->hasFile('profile_image')) {
            // Hapus gambar lama jika ada
            if ($user->profile_image && \Storage::disk('public')->exists($user->profile_image)) {
                \Storage::disk('public')->delete($user->profile_image);
            }

            // Simpan gambar baru
            $user->profile_image = $request->file('profile_image')->store('profile_images', 'public');
        }

        $user->save();

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

        // ✅ CV upload
        if ($request->hasFile('cv')) {
            $workerProfile->cv = $request->file('cv')->store('cv', 'public');
        }

        $workerProfile->keahlian = json_encode($request->keahlian ?? []);

        $workerProfile->linkedin = $request->linkedin ?? $workerProfile->linkedin;

        $workerProfile->empowr_label = $request->has('empowr_label');
        $workerProfile->empowr_affiliate = $request->has('empowr_affiliate');
        $workerProfile->save();

        // ✅ Update Rekening
        $existingAccount = UserPaymentAccount::firstOrNew(['user_id' => $user->id]);
        $existingAccount->wallet_number = $request->wallet_number ?? $existingAccount->wallet_number;
        $existingAccount->ewallet_provider = $request->ewallet_provider ?? $existingAccount->ewallet_provider;
        $existingAccount->ewallet_name = $request->ewallet_account_name ?? $existingAccount->ewallet_name;
        $existingAccount->bank_name = $request->bank_name ?? $existingAccount->bank_name;
        $existingAccount->account_number = $request->account_number ?? $existingAccount->account_number;
        $existingAccount->bank_account_name = $request->bank_account_name ?? $existingAccount->bank_account_name;
        $existingAccount->save();

        return redirect()->route('profil')->with('success-update', 'Profil berhasil diupdate');
    }



    public function updateSertifikasi(Request $request)
    {

        $user = Auth::user();

        $request->validate([
            'certificate_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'title_sertifikasi' => 'nullable|string',
        ]);

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);
        // Sertifikasi
        if ($request->hasFile('certificate_image')) {
            if ($request->has('sertifikasi_id')) {
                $sertifikasi = Sertifikasi::find($request->sertifikasi_id);
                $sertifikasi->title = $request->sertifikat_caption;
                $sertifikasi->save();

                // Hapus gambar lama
                $oldImage = $sertifikasi->images()->first(); // pakai relasi images()
                if ($oldImage && file_exists(public_path($oldImage->image))) {
                    unlink(public_path($oldImage->image));
                    $oldImage->delete();
                }
            } else {
                $sertifikasi = Sertifikasi::create([
                    'worker_id' => $workerProfile->id,
                    'title' => $request->title_sertifikasi,
                ]);
            }

            // Simpan yang baru
            $slugName = Str::slug($user->nama_lengkap ?? 'user');
            $folderPath = public_path('images/sertifikasi/' . $slugName);
            if (!file_exists($folderPath)) mkdir($folderPath, 0777, true);

            $file = $request->file('certificate_image');
            $fileName = round(microtime(true) * 1000) . '-' . $file->getClientOriginalName();
            $file->move($folderPath, $fileName);

            SertifikasiImage::create([
                'sertifikasi_id' => $sertifikasi->id,
                'image' => 'images/sertifikasi/' . $slugName . '/' . $fileName,
            ]);

            return redirect()->route('profil')->with('success-update', 'Profil berhasil diupdate');
        }
    }

    public function updatePortofolio(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'title' => 'nullable|string',
            'portofolio' => 'nullable|array',
            'portofolio.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',
        ]);

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

        $slugName = Str::slug($user->nama_lengkap ?? 'user');
        $folderPath = public_path('images/portofolio/' . $slugName);
        if (!file_exists($folderPath)) mkdir($folderPath, 0777, true);

        // ⬇️ Update portofolio (data saja)
        if ($request->filled('portofolio_id')) {
            $portofolio = Portofolio::find($request->portofolio_id);

            if ($portofolio && $portofolio->worker_id === $workerProfile->id) {
                $portofolio->title = $request->title ?? $portofolio->title;
                $portofolio->description = $request->description ?? $portofolio->description;
                $portofolio->duration = $request->duration ?? $portofolio->duration;
                $portofolio->save();
            }
        } else {
            // ⬇️ Tambah baru
            $portofolio = Portofolio::create([
                'worker_id' => $workerProfile->id,
                'title' => $request->title,
                'description' => $request->description,
                'duration' => $request->duration,
            ]);
        }

        // ⬇️ Jika ada file baru → hapus gambar lama dan ganti
        if ($request->hasFile('portofolio')) {

            $files = is_array($request->file('portofolio')) ? $request->file('portofolio') : [$request->file('portofolio')];
            foreach ($files as $file) {
                $fileName = round(microtime(true) * 1000) . '-' . $file->getClientOriginalName();
                $file->move($folderPath, $fileName);

                PortofolioImage::create([
                    'portofolio_id' => $portofolio->id,
                    'image' => 'images/portofolio/' . $slugName . '/' . $fileName,
                ]);
            }
        }

        return redirect()->route('profil')->with('success-update', 'Portofolio berhasil diperbarui');
    }

    public function deletePortofolioImage($id)
    {
        $image = PortofolioImage::findOrFail($id);

        // Hapus file
        if (file_exists(public_path($image->image))) {
            unlink(public_path($image->image));
        }

        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
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

    public function getWorkerRatingData($workerId)
    {
        try {
            // Get average rating and total reviews directly from task_reviews table
            $ratingStats = \DB::table('task_reviews')
                ->where('reviewed_user_id', $workerId)
                ->whereNotNull('rating')
                ->selectRaw('AVG(rating) as avg_rating, COUNT(rating) as total_reviews')
                ->first();

            $avgRating = $ratingStats->avg_rating ? round($ratingStats->avg_rating, 1) : 0;
            $totalReviews = $ratingStats->total_reviews ?: 0;

            // Get rating breakdown

            // Calculate percentages
            $breakdown = [];
            $labels = [
                5 => 'Excellent',
                4 => 'Good',
                3 => 'Average',
                2 => 'Below Average',
                1 => 'Poor'
            ];

            foreach ($labels as $rating => $label) {
                $found = $ratingBreakdown->firstWhere('rating', $rating);
                $count = $found ? $found->count : 0;
                $percentage = $totalReviews > 0 ? round(($count * 100) / $totalReviews, 1) : 0;
                $breakdown[$label] = $percentage;
            }

            return [
                'avg_rating' => $avgRating,
                'total_reviews' => $totalReviews,
                'breakdown' => $breakdown
            ];
        } catch (\Exception $e) {
            \Log::error("Error getting worker rating data: " . $e->getMessage());
            return [
                'avg_rating' => 0,
                'total_reviews' => 0,
                'breakdown' => [
                    'Excellent' => 0,
                    'Good' => 0,
                    'Average' => 0,
                    'Below Average' => 0,
                    'Poor' => 0
                ]
            ];
        }
    }


    public function getWorkerReviews($workerId, $limit = 10, $offset = 0)
    {
        try {
            $reviews = \DB::table('task_reviews')
                ->join('users', 'task_reviews.user_id', '=', 'users.id')
                ->where('task_reviews.reviewed_user_id', $workerId)
                ->whereNotNull('task_reviews.comment')
                ->where('task_reviews.comment', '!=', '')
                ->select(
                    'task_reviews.id',
                    'task_reviews.rating',
                    'task_reviews.comment',
                    'task_reviews.created_at',
                    'task_reviews.updated_at',
                    'users.id as user_id',
                    'users.nama_lengkap as user_name',
                    'users.profile_image'
                )
                ->orderBy('task_reviews.created_at', 'desc')
                ->limit($limit)
                ->offset($offset)
                ->get();

            // Format reviews for display
            return $reviews->map(function ($review) {
                return [
                    'id' => $review->id,
                    'user_name' => $review->user_name ?: 'Anonymous User',
                    'user_avatar' => $review->profile_image ?
                        asset('storage/' . $review->profile_image) :
                        $this->generateAvatar($review->user_name ?: 'Anonymous'),
                    'rating' => (int)$review->rating,
                    'comment' => $review->comment,
                    'date' => $this->formatDate($review->created_at),
                    'location' => 'Indonesia' // Default location
                ];
            })->toArray();
        } catch (\Exception $e) {
            \Log::error("Error getting worker reviews: " . $e->getMessage());
            return [];
        }
    }


    // Hapus sertifikat
    public function deleteSertifikasi($id)
    {
        $sertifikasi = Sertifikasi::find($id);

        if (!$sertifikasi) {
            return back()->with('error', 'Sertifikasi tidak ditemukan.');
        }

        // Hapus semua gambar terkait
        foreach ($sertifikasi->images as $image) {
            // Hapus file dari storage
            \Storage::disk('public')->delete($image->image);

            // Hapus record dari database
            $image->delete();
        }

        // Hapus sertifikasi utama
        $sertifikasi->delete();

        return back()->with('success', 'Sertifikasi berhasil dihapus.');
    }

    // delete portofolio di profile
    public function deletePortofolio($id)
    {
        $portofolio = Portofolio::with('images')->find($id);

        if (!$portofolio) {
            return back()->with('error', 'Portofolio tidak ditemukan.');
        }

        // Hapus file gambar dari storage
        foreach ($portofolio->images as $image) {
            if (Storage::disk('public')->exists($image->image)) {
                Storage::disk('public')->delete($image->image);
            }
            $image->delete(); // Hapus record dari DB
        }

        // Hapus data portofolio
        $portofolio->delete();

        return back()->with('success', 'Portofolio berhasil dihapus.');
    }
}
