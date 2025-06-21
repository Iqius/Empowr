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
            $ratingData = TaskReview::where('reviewed_user_id', $user)
                ->whereNotNull('rating')
                ->select('rating')
                ->selectRaw('COUNT(*) as count')
                ->groupBy('rating')
                ->orderBy('rating', 'desc')
                ->get();

            return view('General.profil', [
                'workerProfile' => null,
                'sertifikasi' => collect(),
                'portofolio' => collect(),
                'tasks' => $tasks,
                'ratingData' => $ratingData,

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


    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'email' => 'nullable|email',
            'nomor_telepon' => 'nullable|string',
            'bio' => 'nullable|string',

            // ubah validasi keahlian
            'keahlian' => 'nullable|array',
            'keahlian.*' => 'string|max:255',

            'pengalaman_kerja' => 'nullable|string',
            'pendidikan' => 'nullable|string',
            'cv' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg|max:10240',

            'certificate_image' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
            'title_sertifikasi' => 'nullable|string',
            'title' => 'nullable|string',
            'portofolio' => 'nullable|array',
            'portofolio.*' => 'file|mimes:jpg,jpeg,png|max:2048',
            'description' => 'nullable|string',
            'duration' => 'nullable|integer',

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
        $user->save();

        $workerProfile = $user->workerProfile ?? new WorkerProfile(['user_id' => $user->id]);

        // CV upload
        if ($request->hasFile('cv')) {
            $workerProfile->cv = $request->file('cv')->store('cv', 'public');
        }

        // ✅ Simpan array keahlian sebagai JSON
        $workerProfile->keahlian = json_encode($request->keahlian ?? []);

        $workerProfile->linkedin = $request->linkedin ?? $workerProfile->linkedin;
        $workerProfile->pengalaman_kerja = $request->pengalaman_kerja ?? $workerProfile->pengalaman_kerja;
        $workerProfile->pendidikan = $request->pendidikan ?? $workerProfile->pendidikan;

        $workerProfile->empowr_label = $request->has('empowr_label');
        $workerProfile->empowr_affiliate = $request->has('empowr_affiliate');
        $workerProfile->save();

        // Rekening
        $existingAccount = UserPaymentAccount::firstOrNew(['user_id' => $user->id]);
        $existingAccount->wallet_number = $request->wallet_number ?? $existingAccount->wallet_number;
        $existingAccount->ewallet_provider = $request->ewallet_provider ?? $existingAccount->ewallet_provider;
        $existingAccount->bank_name = $request->bank_name ?? $existingAccount->bank_name;
        $existingAccount->account_number = $request->account_number ?? $existingAccount->account_number;
        $existingAccount->account_name = $request->account_name ?? $existingAccount->account_name;
        $existingAccount->ewallet_name = $request->ewallet_name ?? $existingAccount->ewallet_name;
        $existingAccount->save();

        // Sertifikasi
        if ($request->hasFile('certificate_image')) {
            if ($request->has('sertifikasi_id')) {
                $sertifikasi = Sertifikasi::find($request->sertifikasi_id);
                $sertifikasi->title = $request->sertifikat_caption;
                $sertifikasi->save();
            } else {
                $sertifikasi = Sertifikasi::create([
                    'worker_id' => $workerProfile->id,
                    'title' => $request->title_sertifikasi,
                ]);
            }

            $sertifImage = $request->file('certificate_image')->store('sertifikasi', 'public');

            SertifikasiImage::create([
                'sertifikasi_id' => $sertifikasi->id,
                'image' => $sertifImage,
            ]);
        }

        // Portofolio
        if ($request->hasFile('portofolio')) {
            $portofolio = Portofolio::firstOrNew([
                'worker_id' => $workerProfile->id,
                'title' => $request->title,
            ]);

            $portofolio->description = $request->description ?? $portofolio->description;
            $portofolio->duration = $request->duration ?? $portofolio->duration;
            $portofolio->save();

            foreach ($request->file('portofolio') as $file) {
                $portoImagePath = $file->store('portofolio', 'public');

                PortofolioImage::create([
                    'portofolio_id' => $portofolio->id,
                    'image' => $portoImagePath,
                ]);
            }
        }

        return redirect()->route('profil')->with('success-update', 'Profil berhasil diupdate');
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

    /**
     * Get reviews for a worker
     */
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
}
