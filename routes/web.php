<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\RoleMiddleware;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProgressionController;


// LANDING PAGE
Route::get('/', function () {
    return view('Landing.landing');
});



// AUTHENTIKASI
Route::get('/register', function () {return view('auth.register');})->name('register');
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
Route::post('/bayar/{task}', [JobController::class, 'bayar'])->name('client.bayar');
// --Buat job
Route::post('/jobs', [JobController::class, 'createJobClient'])->name('jobs.store');
// --review progress
Route::post('/task-progression/{progress}/review', [ProgressionController::class, 'review'])->name('task-progression.review');



// WORKER
// -- DASHBOARD
Route::get('/worker/dashboard', [AuthController::class, 'workerDashboard'])->middleware(['auth'])->name('worker.dashboardWorker');
// MyJobs
Route::get('/dashboard/Myjobs', [JobController::class, 'myJobsWorker'])->name('jobs.Worker');
// Upload Progress
Route::post('/task-progression/{task}', [ProgressionController::class, 'create'])->name('task-progression.store');


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














Route::get('/jobs/manage/{id}', [JobController::class, 'manage'])->name('jobs.manage');
Route::delete('/jobs/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/jobs/data', [JobController::class, 'getJobData'])->name('jobs.data');


Route::get('/my-job-worker', function () {return view('myJobWorker');})->name('myjob.worker');
Route::get('/worker/myjob/{id}', [JobController::class, 'manageWorker'])->name('manage.worker');


Route::post('/task/{task}/apply', [JobController::class, 'apply'])->name('task.apply');
Route::post('/application/{id}/accept', [JobController::class, 'accept'])->name('application.accept');

Route::get('/tasks/{id}/applicants', [JobController::class, 'showApplicants']);

//arbitrae
Route::get('/arbitrase', function () {return view('arbitrase');});



Route::post('/profile/update-image', [ProfileController::class, 'updateProfileImage']);


//notif
Route::get('/notifikasi', [NotificationController::class, 'index'])->name('notifications.index');
Route::post('/notifikasi/baca-semua', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');

