<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Common (no alias needed for Auth)
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController   as CommonRestaurantController;
use App\Http\Controllers\Common\ProductController      as CommonProductController;
use App\Http\Controllers\Common\CategoryController     as CommonCategoryController;
use App\Http\Controllers\Common\RestaurantLocationController as CommonRestaurantLocationController;
use App\Http\Controllers\Common\RecommendationController as CommonRecommendationController;

// Owner
use App\Http\Controllers\Owner\ProductController       as OwnerProductController;
use App\Http\Controllers\Owner\CategoryController      as OwnerCategoryController;

// Owner linking controllers
use App\Http\Controllers\ProductLocationController;
use App\Http\Controllers\CategoryLocationController;

// Admin
use App\Http\Controllers\Admin\RestaurantController           as AdminRestaurantController;
use App\Http\Controllers\Admin\RestaurantLocationController   as AdminLocationController;

Route::prefix('v0.1')->group(function () {

    // Guest (no auth)
    Route::prefix('guest')->group(function () {
        Route::post('login',  [AuthController::class, 'login']);
        Route::post('signup', [AuthController::class, 'signup']);
    });

    // Authenticated
    Route::middleware('auth:api')->group(function () {

        // Get current user
        Route::get('user', function (Request $request) {
            return $request->user();
        });

        // Common endpoints
        Route::prefix('common')->group(function () {
            Route::get('restaurants',               [CommonRestaurantController::class, 'index']);
            Route::get('restaurant/{id}/homepage',  [CommonRestaurantController::class, 'show']);
            Route::get('restaurant/{id}/branches',  [CommonRestaurantLocationController::class, 'branches']);
            Route::get('products',                  [CommonProductController::class,  'index']);
            Route::get('products/{id}',             [CommonProductController::class,  'show']);
            Route::get('categories',                [CommonCategoryController::class, 'index']);

            // Recommendations
            Route::get('recommendations',          [CommonRecommendationController::class, 'index']);

        });

        // Owner endpoints
        Route::prefix('owner')->group(function () {

            // Products
            Route::prefix('product')->group(function () {
                Route::post('/',            [OwnerProductController::class, 'store']);
                Route::get('{id}',          [OwnerProductController::class, 'show']);
                Route::put('{id}',          [OwnerProductController::class, 'update']);
                Route::delete('{id}',       [OwnerProductController::class, 'destroy']);

                // Link/unlink branches
                Route::post('{product}/locations',               [ProductLocationController::class, 'store']);
                Route::delete('{product}/locations/{branch}',    [ProductLocationController::class, 'destroy']);
            });

            // Categories
            Route::prefix('categories')->group(function () {
                Route::post('/',            [OwnerCategoryController::class, 'store']);
                Route::put('{id}',          [OwnerCategoryController::class, 'update']);
                Route::delete('{id}',       [OwnerCategoryController::class, 'destroy']);

                // Link/unlink branches
                Route::post('{category}/locations',             [CategoryLocationController::class, 'store']);
                Route::delete('{category}/locations/{branch}',  [CategoryLocationController::class, 'destroy']);
            });
        });

        // Admin endpoints
        Route::prefix('admin')->group(function () {

            // Restaurants
            Route::prefix('restaurants')->group(function () {
                Route::post('/',        [AdminRestaurantController::class,       'store']);
                Route::put('{id}',      [AdminRestaurantController::class,       'update']);
                Route::delete('{id}',   [AdminRestaurantController::class,       'destroy']);
            });

            // Branches (Restaurant Locations)
            Route::prefix('restaurant-locations')->group(function () {
                Route::post('/',        [AdminLocationController::class,         'store']);
                Route::put('{id}',      [AdminLocationController::class,         'update']);
                Route::delete('{id}',   [AdminLocationController::class,         'destroy']);
            });
        });
    });
});
