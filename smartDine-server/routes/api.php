<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\ProductController;
use App\Http\Controllers\Common\RestaurantController;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['prefix' => 'v0.1'], function () {
    Route::group(['prefix' => 'guest'], function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/signup', [AuthController::class, 'signup']);
    });
    Route::group(['middleware'=>'auth:api'],function(){
        
        // Common:
        Route::group(['prefix' => 'common'], function () {
            Route::get('restaurants',                 [RestaurantController::class,'index']);
            Route::get('restaurant/{id}/homepage',  [RestaurantController::class,'show']);
            Route::get('products',                  [ProductController::class,'commonIndex']);
        });

        // Owner only:
        Route::group(['prefix' => 'owner'], function(){
            Route::get('product',             [ProductController::class,'ownerIndex']);
            Route::post('product',            [ProductController::class,'store']);
            Route::get('product/{product}',   [ProductController::class,'show']);
            Route::put('product/{product}',   [ProductController::class,'update']);
            Route::delete('product/{product}',[ProductController::class,'destroy']);
        });
    });
});
