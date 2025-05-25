<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProgressionController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ArbitraseController;

// LANDING PAGE
Route::get('/', function () {
    return view('Landing.landing');
});



// AUTHENTIKASI
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotForm'])->name('forgot-password.form');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('forgot-password.send-otp');

Route::get('/verify-otp', [AuthController::class, 'showOtpForm'])->name('forgot-password.otp-form');
Route::post('/verify-otp-check', [AuthController::class, 'checkOtp'])->name('forgot-password.verify-otp-check');

// Langkah 2: Set password baru
Route::get('/set-password', [AuthController::class, 'showSetPasswordForm'])->name('forgot-password.set-password-form');
Route::post('/verify-otp-set-password', [AuthController::class, 'setNewPassword'])->name('forgot-password.set-new-password');
Route::post('/resend-otp', [AuthController::class, 'resendOtp'])->name('forgot-password.resend-otp');

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// CLIENT
// -- DASHBOARD
Route::get('/client/dashboard', [AuthController::class, 'clientDashboard'])->middleware(['auth'])->name('client.dashboardClient');
// --Show profile worker yang melamar
Route::get('/profil/{id}', [ProfileController::class, 'showProfileWorkerLamar'])->name('profile.worker.lamar');
// --Hire worker
Route::post('/hire', [JobController::class, 'Clienthire'])->name('client.hire');
// --Client Tolak Worker
Route::post('/reject', [JobController::class, 'ClientReject'])->name('client.reject');
// --bayar
Route::post('/bayar/{task?}', [JobController::class, 'bayar'])->name('client.bayar');
// --review progress
Route::post('/task-progression/{progress}/review', [ProgressionController::class, 'review'])->name('task-progression.review');
// --Client complete job
Route::post('/task/{task}/complite', [ProgressionController::class, 'CompliteJob'])->name('complite.job');
// --Tampilkan halaman Add Job New
Route::post('/jobs', [JobController::class, 'createJobClient'])->name('jobs.store');
Route::get('/add-job', function () {
    return view('client.addJobNew');
})->middleware(['auth'])->name('client.addJobNew');
// --Tampilkan halaman update dpake client dan admin
Route::post('/progress/update-jobs/{id}', [JobController::class, 'updateJobClient'])->name('jobs.update');
Route::get('/update-job/{id}', [JobController::class, 'updateJobView'])->middleware(['auth'])->name('client.update');




// WORKER
// -- DASHBOARD
Route::get('/worker/dashboard', [AuthController::class, 'workerDashboard'])->middleware(['auth'])->name('worker.dashboardWorker');
// MyJobs
Route::get('/dashboard/Myjobs', [JobController::class, 'myJobsWorker'])->name('jobs.Worker');
// Upload Progress
Route::post('/task-progression/{task}', [ProgressionController::class, 'create'])->middleware(['auth'])->name('task-progression.store');
// Post ulasan worker pada saat complite task
Route::post('/task-progression/ulasan/{task}', [ProgressionController::class, 'ulasanWorker'])->middleware(['auth'])->name('task-ulasan.store');
Route::get('/dashboard1', function () {
    $user = Auth::user();
    return match ($user->role) {
        'client' => redirect()->route('client.dashboardClient'),
        'worker' => redirect()->route('worker.dashboardWorker'),
        'admin'  => redirect()->route('admin.dashboardAdmin'),
        default  => redirect('/'),
    };
})->middleware(['auth'])->name('dashboard');

####### GENERAL
// List all Jobs
Route::get('/dashboard/jobs', [JobController::class, 'index'])->name('jobs.index');
// detail jobs di fitur jobs
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('jobs.my');
// --Profile update
Route::get('/profil', [ProfileController::class, 'showProfile'])->name('profil');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');
// --CHAT MASIH BELUM PASTI
Route::get('/chat', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('chat');
// --In progress jobs
Route::get('/in-progress-jobs/{task_id}', [JobController::class, 'DetailJobsInProgress'])->name('inProgress.jobs');
// --arbitrase
// web.php
Route::get('/arbitrase', [ArbitraseController::class, 'indexUser'])->name('arbitrase.user');


//chat
Route::get('/chat/search', [ChatController::class, 'search'])->middleware(['auth', 'admin'])->name('chat.search');
Route::get('/chat', [ChatController::class, 'index'])->middleware(['auth'])->name('chat.index'); // Ubah dari 'chat.show' ke 'chat.index'
Route::get('/chat/{user}', [ChatController::class, 'show'])->middleware(['auth'])->name('chat.show');
Route::post('/chat', [ChatController::class, 'store'])->middleware(['auth'])->name('chat.store');
Route::delete('/chat/{conversation}', [ChatController::class, 'destroy'])->middleware(['auth'])->name('chat.destroy');
Route::post('/chat/finish/{id}', [ChatController::class, 'finishConversation'])->name('chat.finish');
Route::delete('/chat/destroy/{id}', [ChatController::class, 'destroyConversation'])->name('chat.destroy');
// Route::get('/chat/messages', [ChatController::class, 'fetchMessages']);
// --notif
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifikasi/baca-semua', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
// --Ewallet
Route::get('/ewallet/{id}', [JobController::class, 'ewalletIndex'])->name('ewallet.index');
Route::post('/ewallet/pembayaran/{id}', [JobController::class, 'bayarEwalletBase'])->name('client.bayar.ewallet');






####### ADMIN
// Dashboard
Route::get('/admin/dashboard', [AuthController::class, 'adminDashboard'])->middleware(['auth'])->name('admin.dashboardAdmin');
Route::get('/arbitraseget', [ArbitraseController::class, 'index'])->middleware(['auth'])->name('arbitrase.index');
Route::get('/arbitraseDetail', [ArbitraseController::class, 'index'])->middleware(['auth'])->name('arbitrase.show');
Route::post('/arbitrase/{id}/accept', [ArbitraseController::class, 'accept'])->name('arbitrase.accept');
Route::post('/arbitrase/{id}/reject', [ArbitraseController::class, 'reject'])->name('arbitrase.reject');
// 

#### Arbitrase
Route::post('/arbitrase/laporkan', [ArbitraseController::class, 'store'])->middleware(['auth'])->name('arbitrase.store');


Route::get('/jobs/manage/{id}', [JobController::class, 'manage'])->name('jobs.manage');
Route::delete('/jobs/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/jobs/data', [JobController::class, 'getJobData'])->name('jobs.data');


Route::get('/my-job-worker', function () {
    return view('myJobWorker');
})->name('myjob.worker');
Route::get('/worker/myjob/{id}', [JobController::class, 'manageWorker'])->name('manage.worker');


Route::post('/task/{task}/apply', [JobController::class, 'apply'])->name('task.apply');
Route::post('/application/{id}/accept', [JobController::class, 'accept'])->name('application.accept');

Route::get('/tasks/{id}/applicants', [JobController::class, 'showApplicants']);

Route::post('/profile/update-image', [ProfileController::class, 'updateProfileImage']);
Route::get('/jobs', [JobController::class, 'addJobView'])->name('add-job-view');
