<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v0.1'], function () {
    Route::group(['prefix' => 'guest'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/signup', [AuthController::class, 'signup']);
    });
    Route::group(['prefix' => 'common'], function () {
        Route::group(['prefix' => 'product'], function () {
            Route::get('/', [ProductController::class, 'commonIndex']);
            Route::get('/{product}', [ProductController::class, 'show']);
        });
        Route::group(['prefix' => 'restaurant'], function () {
            Route::get('/', [RestaurantController::class, 'index']);
            Route::get('/{id}', [RestaurantController::class, 'show']);
        });
    });
    Route::group(['prefix' => 'owner'], function () {
        Route::group(['prefix' => 'product','middleware'=> 'auth:api'], function () {
            Route::get('/', [ProductController::class, 'ownerIndex']);
            Route::post('/', [ProductController::class, 'store']);
            Route::put('/{product}', [ProductController::class, 'update']);
            Route::delete('/{product}', [ProductController::class, 'destroy']);
        });
    });
});
