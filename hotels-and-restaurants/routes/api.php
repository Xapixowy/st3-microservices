<?php

use App\Http\Controllers\HotelController;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TableController;
use Illuminate\Support\Facades\Route;

Route::apiResource('hotels', HotelController::class)->only(['index', 'show']);
Route::apiResource('hotels', HotelController::class)->only(['store', 'update', 'destroy']);

Route::prefix('hotels')->name('hotels.')->group(function () {
    Route::apiResource('{hotel}/rooms', RoomController::class)->only(['index', 'show']);
    Route::apiResource('{hotel}/rooms', RoomController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'rooms.store',
        'update' => 'rooms.update',
    ]);
});

Route::apiResource('restaurants', RestaurantController::class)->only(['index', 'show']);
Route::apiResource('restaurants', RestaurantController::class)->only(['store', 'update', 'destroy']);

Route::prefix('restaurants')->name('restaurants.')->group(function () {
    Route::apiResource('{restaurant}/tables', TableController::class)->only(['index', 'show']);
    Route::apiResource('{restaurant}/tables', TableController::class)->only(['store', 'update', 'destroy'])->names([
        'store' => 'tables.store',
        'update' => 'tables.update',
    ]);
});
