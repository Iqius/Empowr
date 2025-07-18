<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::post('/midtrans-callback', [PaymentController::class, 'callback']);

Route::get('/invoice/{id}', [JobController::class, 'invoice'])->name('invoice');