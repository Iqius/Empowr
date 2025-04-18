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
// --Show profile worker yang melamar
Route::get('/profil/{id}', [ProfileController::class, 'showProfileWorkerLamar'])->name('profile.worker.lamar');
// --Hire worker
Route::post('/hire', [JobController::class, 'Clienthire'])->name('client.hire');
// --Client Tolak Worker
Route::post('/reject', [JobController::class, 'ClientReject'])->name('client.reject');



// WORKER
// -- DASHBOARD
Route::get('/worker/dashboard', [AuthController::class, 'workerDashboard'])->middleware(['auth'])->name('worker.dashboardWorker');
// MyJobs
Route::get('/dashboard/Myjobs', [JobController::class, 'myJobsWorker'])->name('jobs.Worker');



// --Profile update
Route::get('/profil', [ProfileController::class, 'showProfile'])->name('profil');
Route::post('/profile/update', [ProfileController::class, 'updateProfile'])->name('profile.update');





####### GENERAL
// List all Jobs
Route::get('/dashboard/jobs', [JobController::class, 'index'])->name('jobs.index');
// detail jobs di fitur jobs
Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');






// Authentication Routes


// Dashboard (Protected by Auth Middleware)
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

   
    

    // Client & Worker Dashboard
   
    Route::get('/client/new', [AuthController::class, 'clientNew'])->name('client.new');
    
    
    // Job Routes
    // Memastikan data dikirim ke view
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

    //chat
    Route::get('/chat', [\Chatify\Http\Controllers\MessagesController::class, 'index'])->name('chat');
    

});
// Route::post('/update-profile', [UserController::class, 'update']);

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





Route::post('/profile/update-image', [ProfileController::class, 'updateProfileImage']);


