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

