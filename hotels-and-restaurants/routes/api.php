<?php

use App\Http\Controllers\Api\HotelController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hotels', HotelController::class)->only(['index', 'show']);
Route::apiResource('hotels', HotelController::class)->only(['store', 'update', 'destroy']);

