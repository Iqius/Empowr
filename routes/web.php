<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;

// Landing Page
Route::get('/', function () {
    return view('Landing.landing');
});

// Authentication Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Dashboard (Protected by Auth Middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil User
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    Route::post('/profil/update', [AuthController::class, 'updateProfile'])->name('profil.update');

    // Client & Worker Dashboard
    Route::get('/client/dashboard', [AuthController::class, 'clientDashboard'])->name('client.dashboardClient');
    Route::get('/worker/dashboard', [AuthController::class, 'workerDashboard'])->name('worker.dashboardWorker');
    Route::get('/client/new', [AuthController::class, 'clientNew'])->name('client.new');
    Route::get('/worker/jobs', [AuthController::class, 'workerJobs'])->name('worker.jobs');

    // Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index'); // Memastikan data dikirim ke view
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

    //chat
    Route::get('/chat', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('chat');

});
// Route::post('/update-profile', [UserController::class, 'update']);
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
Route::get('/my-jobs', [JobController::class, 'myJobs'])->name('jobs.my');
Route::get('/jobs/manage/{id}', [JobController::class, 'manage'])->name('jobs.manage');
Route::delete('/jobs/delete/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
Route::get('/profile/show', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/jobs/data', [JobController::class, 'getJobData'])->name('jobs.data');
// Route::get('/jobs/{job}/chat/{user}', [ChatController::class, 'index'])->name('jobs.chat');
// Route::post('/jobs/{job}/chat/{user}', [ChatController::class, 'send'])->name('jobs.chat.send');
Route::get('/manage-worker', function () {return view('manageWorker');})->name('manage.worker');
Route::get('/my-job-worker', function () {return view('myJobWorker');})->name('myjob.worker');

Route::post('/task/{task}/apply', [JobController::class, 'apply'])->name('task.apply');
Route::post('/application/{id}/accept', [JobController::class, 'accept'])->name('application.accept');

Route::get('/tasks/{id}/applicants', [JobController::class, 'showApplicants']);



Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/profile/update-image', [ProfileController::class, 'updateProfileImage']);

Route::get('/profil', [AuthController::class, 'showProfile'])->name('profil');
