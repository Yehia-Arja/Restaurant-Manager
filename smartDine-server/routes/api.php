<?php

<<<<<<< HEAD
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController;
use App\Http\Controllers\Common\ProductController;
use App\Http\Controllers\Common\CategoryController;
use App\Models\Category;

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
            Route::get('products',                     [ProductController::class, 'index']);
            Route::get('products/{id}',                [ProductController::class, 'show']);

            Route::get('categories',                   [CategoryController::class, 'index']);
        });

        // Owner endpoints (only owners hit these)
        Route::group(['prefix' => 'owner/product'], function () {
            Route::post('/',     [ProductController::class, 'store']);
            Route::get('{id}',   [ProductController::class, 'show']);
            Route::put('{id}',   [ProductController::class, 'update']);
            Route::delete('{id}',[ProductController::class, 'destroy']);

            Route::post('categories', [CategoryController::class, 'store']);
            Route::put('categories/{id}', [CategoryController::class, 'update']);
            Route::delete('categories/{id}', [CategoryController::class, 'destroy']);
        });

        // Admin endpoints (only admins hit these)
        Route::group(['prefix' => 'admin'], function () {
            Route::post('restaurants', [RestaurantController::class, 'store']);
            Route::put('restaurants/{id}', [RestaurantController::class, 'update']);
            Route::delete('restaurants/{id}', [RestaurantController::class, 'destroy']);
=======
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Common
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController as CommonRestaurantController;
use App\Http\Controllers\Common\ProductController as CommonProductController;
use App\Http\Controllers\Common\CategoryController as CommonCategoryController;
use App\Http\Controllers\Common\RestaurantLocationController as CommonRestaurantLocationController;
use App\Http\Controllers\Common\RecommendationController as CommonRecommendationController;

// Client
use App\Http\Controllers\Client\FavoriteController;

// Owner
use App\Http\Controllers\Owner\ProductController as OwnerProductController;
use App\Http\Controllers\Owner\CategoryController as OwnerCategoryController;

// Linking
use App\Http\Controllers\ProductLocationController;
use App\Http\Controllers\CategoryLocationController;

// Admin
use App\Http\Controllers\Admin\RestaurantController as AdminRestaurantController;
use App\Http\Controllers\Admin\RestaurantLocationController as AdminLocationController;

Route::group(["prefix" => "v0.1"], function () {
    // Guest (no auth)
    Route::group(["prefix" => "guest"], function () {
        Route::post("login",  [AuthController::class, "login"]);
        Route::post("signup", [AuthController::class, "signup"]);
    });

    // Common endpoints (authenticated)
    Route::group([
        "prefix"     => "common",
        "middleware" => "auth:api",
    ], function () {
        // Products
        Route::group(["prefix" => "products"], function () {
            Route::get("/",     [CommonProductController::class, "index"]);
            Route::get("/{id}", [CommonProductController::class, "show"]);
        });

        // Categories
        Route::group(["prefix" => "categories"], function () {
            Route::get("/",     [CommonCategoryController::class, "index"]);
            Route::get("/{id}", [CommonCategoryController::class, "show"]);
        });

        // Restaurants
        Route::group(["prefix" => "restaurants"], function () {
            Route::get("/",     [CommonRestaurantController::class, "index"]);
            Route::get("/{id}", [CommonRestaurantController::class, "show"]);
        });

        // Restaurant Locations
        Route::group(["prefix" => "restaurant-locations"], function () {
            Route::get("/",     [CommonRestaurantLocationController::class, "index"]);
            Route::get("/{id}", [CommonRestaurantLocationController::class, "show"]);
        });

        // Recommendations
        Route::group(["prefix" => "recommendations"], function () {
            Route::get("/", [CommonRecommendationController::class, "index"]);
        });

        // Favorites (Client)
        Route::group(["prefix" => "favorites"], function () {
            Route::post("/", [FavoriteController::class, "toggle"]);
        });
    });

    // Owner endpoints (authenticated)
    Route::group([
        "prefix"     => "owner",
        "middleware" => "auth:api",
    ], function () {
        // Products
        Route::group(["prefix" => "product"], function () {
            Route::post("/",           [OwnerProductController::class, "store"]);
            Route::get("/{id}",        [OwnerProductController::class, "show"]);
            Route::put("/{id}",        [OwnerProductController::class, "update"]);
            Route::delete("/{id}",     [OwnerProductController::class, "destroy"]);

            Route::post("/{product}/locations",            [ProductLocationController::class, 'store']);
            Route::delete("/{product}/locations/{branch}",[ProductLocationController::class, 'destroy']);
        });

        // Categories
        Route::group(["prefix" => "categories"], function () {
            Route::post("/",           [OwnerCategoryController::class, "store"]);
            Route::put("/{id}",        [OwnerCategoryController::class, "update"]);
            Route::delete("/{id}",     [OwnerCategoryController::class, "destroy"]);

            Route::post("/{category}/locations",            [CategoryLocationController::class, 'store']);
            Route::delete("/{category}/locations/{branch}", [CategoryLocationController::class, 'destroy']);
        });
    });

    // Admin endpoints (authenticated)
    Route::group([
        "prefix"     => "admin",
        "middleware" => "auth:api",
    ], function () {
        // Restaurants
        Route::group(["prefix" => "restaurants"], function () {
            Route::post("/",       [AdminRestaurantController::class, "store"]);
            Route::put("/{id}",    [AdminRestaurantController::class, "update"]);
            Route::delete("/{id}", [AdminRestaurantController::class, "destroy"]);
        });

        // Branches
        Route::group(["prefix" => "restaurant-locations"], function () {
            Route::post("/",       [AdminLocationController::class, "store"]);
            Route::put("/{id}",    [AdminLocationController::class, "update"]);
            Route::delete("/{id}", [AdminLocationController::class, "destroy"]);
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
        });
    });
});
