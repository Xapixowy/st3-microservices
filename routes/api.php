<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HotelController;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/activate', [AuthController::class, 'activate'])->name('activate');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::apiResource('hotels', HotelController::class)->except(['store', 'update', 'destroy']);
Route::apiResource('hotels', HotelController::class)->only(['store', 'update', 'destroy'])->middleware('auth:sanctum');
