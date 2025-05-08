<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// alias the two ProductController classes
use App\Http\Controllers\Common\ProductController as CommonProductController;
use App\Http\Controllers\Owner\ProductController  as OwnerProductController;

// other controllers
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController;
use App\Http\Controllers\Common\CategoryController;

Route::group(['prefix' => 'v0.1'], function () {

    // Guest (no auth) 
    Route::group(['prefix' => 'guest'], function () {
        Route::post('login',  [AuthController::class,   'login']);
        Route::post('signup', [AuthController::class,   'signup']);
    });

    // Authenticated 
    Route::group(['middleware' => ['auth:api']], function () {

        Route::get('user', function (Request $request) {
            return $request->user();
        });

        //  Common endpoints (any logged-in user)
        Route::group(['prefix' => 'common'], function () {
            Route::get('restaurants',              [RestaurantController::class,   'index']);
            Route::get('restaurant/{id}/homepage', [RestaurantController::class,   'show']);
            Route::get('products',                 [CommonProductController::class, 'index']);
            Route::get('products/{id}',            [CommonProductController::class, 'show']);
            Route::get('categories',               [CategoryController::class,      'index']);
        });

        // Owner endpoints (only owners hit these)
        Route::group(['prefix' => 'owner/product'], function () {
            Route::post('/',      [OwnerProductController::class,  'store']);    // you can alias here too
            Route::get('{id}',    [OwnerProductController::class,  'show']);
            Route::put('{id}',    [OwnerProductController::class,  'update']);
            Route::delete('{id}', [OwnerProductController::class,  'destroy']);

            Route::post('categories',                 [CategoryController::class, 'store']);
            Route::put('categories/{id}',             [CategoryController::class, 'update']);
            Route::delete('categories/{id}',          [CategoryController::class, 'destroy']);
        });

        // Admin endpoints (only admins)
        Route::group(['prefix' => 'admin'], function () {
            Route::post('restaurants',          [RestaurantController::class, 'store']);
            Route::put('restaurants/{id}',      [RestaurantController::class, 'update']);
            Route::delete('restaurants/{id}',   [RestaurantController::class, 'destroy']);
        });
    });
});
