<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController;
use App\Http\Controllers\Common\ProductController;

Route::group(['prefix' => 'v0.1'], function () {

    //Guest (no auth) 
    Route::group(['prefix' => 'guest'], function () {
        Route::post('login',  [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
    });

    // Authenticated 
    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('user', function (Request $request) {
            return $request->user();
        });

        //  Common endpoints (any logged-in user)
        Route::group(['prefix' => 'common'], function () {
            Route::get('restaurants',                  [RestaurantController::class, 'index']);
            Route::get('restaurant/{id}/homepage',     [RestaurantController::class, 'show']);
            Route::get('products',                     [ProductController::class, 'commonIndex']);
            Route::get('products/{product}',           [ProductController::class, 'show']);
        });

        // Owner endpoints (only owners hit these)
        Route::group(['prefix' => 'owner'], function () {
            Route::post('product/store',      [ProductController::class, 'store']);
            Route::get('product/{id}',         [ProductController::class, 'show']);
            Route::put('product/{id}',        [ProductController::class, 'update']);
            Route::delete('product/{id}',      [ProductController::class, 'destroy']);
        });

        // Admin endpoints (only admins hit these)
        Route::group(['prefix' => 'admin'], function () {
            Route::post('restaurants', [RestaurantController::class, 'store']);
            Route::put('restaurants/{id}', [RestaurantController::class, 'update']);
            Route::delete('restaurants/{id}', [RestaurantController::class, 'destroy']);
        });
    });
});
