<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});
Route::view('/login', 'login')->name('login');
Route::view('/register', 'register')->name('register');

Route::view('/loginregister', 'loginregister')->name('loginregister');
Route::view('/jobs', 'jobs')->name('jobs');
Route::view('/new', 'new')->name('new');

Route::view('/profil', 'profil')->name('profil');

use App\Http\Controllers\AuthController;

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'register']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware('auth')->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/new', [AuthController::class, 'clientDashboard'])->name('client.new');
    Route::get('/jobs', [AuthController::class, 'workerDashboard'])->name('worker.jobs');
});

Route::post('/profil/update', [AuthController::class, 'updateProfile'])->name('profil.update')->middleware('auth');
