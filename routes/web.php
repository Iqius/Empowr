<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\JobController;

// Landing Page
Route::get('/', function () {
    return view('landing');
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
    Route::get('/client/new', [AuthController::class, 'clientDashboard'])->name('client.new');
    Route::get('/worker/jobs', [AuthController::class, 'workerDashboard'])->name('worker.jobs');

    // Job Routes
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index'); // Memastikan data dikirim ke view
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
});

