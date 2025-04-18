<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\Cors;
use Illuminate\Http\Middleware\HandleCors;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/activate', [AuthController::class, 'activate'])->name('activate');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth:sanctum');
    Route::get('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
});

Route::prefix('countries')->name('countries.')->group(function () {
    Route::get('/', [CountryController::class, 'index'])->name('index');
    Route::get('/find', [CountryController::class, 'find'])->name('find');
});

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/find/{id}', [UserController::class, 'find'])->name('find');
});
