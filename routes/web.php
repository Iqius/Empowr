<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\CheckUserRole;
use App\Http\Middleware\RoleMiddleware;


// LANDING PAGE
Route::get('/', function () {
    return view('Landing.landing');
});



// AUTHENTIKASI
Route::get('/register', function () {return view('auth.register');})->name('register');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// CLIENT
// -- DASHBOARD
Route::get('/client/dashboard', [AuthController::class, 'clientDashboard'])->middleware(['auth'])->name('client.dashboardClient');









// Authentication Routes


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
   
    Route::get('/worker/dashboard', [AuthController::class, 'workerDashboard'])->middleware(['auth'])->name('worker.dashboardWorker');
    Route::get('/client/new', [AuthController::class, 'clientNew'])->name('client.new');
    Route::get('/dashboard/jobs', [AuthController::class, 'workerJobs'])->name('list.jobs');

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
// Route::get('/manage-worker/{id}', [JobController::class, 'manage'])->name('manage');
Route::get('/my-job-worker', function () {return view('myJobWorker');})->name('myjob.worker');
Route::get('/worker/myjob/{id}', [JobController::class, 'manageWorker'])->name('manage.worker');

Route::post('/task/{task}/apply', [JobController::class, 'apply'])->name('task.apply');
Route::post('/application/{id}/accept', [JobController::class, 'accept'])->name('application.accept');

Route::get('/tasks/{id}/applicants', [JobController::class, 'showApplicants']);



Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

Route::post('/profile/update-image', [ProfileController::class, 'updateProfileImage']);

Route::get('/profil', [AuthController::class, 'showProfile'])->name('profil');
