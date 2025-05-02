<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Owner\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v0.1'], function () {
    Route::group(['prefix' => 'guest'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/signup', [AuthController::class, 'signup']);
    });
    Route::group(['prefix' => 'owner'], function () {
        Route::group(['prefix' => 'product','middleware'=> 'auth:api'], function () {
            Route::get('/', [ProductController::class, 'index']);
            Route::post('/', [ProductController::class, 'store']);
            Route::get('/{product}', [ProductController::class, 'show']);
            Route::put('/{product}', [ProductController::class, 'update']);
            Route::delete('/{product}', [ProductController::class, 'destroy']);
        });
    });
});
