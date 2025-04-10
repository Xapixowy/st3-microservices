<?php

use App\Http\Controllers\ReservationController;
use Illuminate\Support\Facades\Route;

Route::apiResource('reservations', ReservationController::class)->only(['index', 'show']);
Route::apiResource('reservations', ReservationController::class)->only(['store', 'update', 'destroy']);
