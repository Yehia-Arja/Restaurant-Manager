<?php 

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

// Common
use App\Http\Controllers\Common\AuthController;
use App\Http\Controllers\Common\RestaurantController as CommonRestaurantController;
use App\Http\Controllers\Common\ProductController as CommonProductController;
use App\Http\Controllers\Common\CategoryController as CommonCategoryController;
use App\Http\Controllers\Common\RestaurantLocationController as CommonRestaurantLocationController;
use App\Http\Controllers\Common\RecommendationController as CommonRecommendationController;
use App\Http\Controllers\Common\TableController as CommonTableController;

// Client
use App\Http\Controllers\Client\OrderController as ClientOrderController;
use App\Http\Controllers\Client\FavoriteController;
use App\Http\Controllers\Client\ChatController;

// Owner
use App\Http\Controllers\Owner\ProductController as OwnerProductController;
use App\Http\Controllers\Owner\CategoryController as OwnerCategoryController;
use App\Http\Controllers\Owner\TableController as OwnerTableController;

// Linking
use App\Http\Controllers\ProductLocationController;
use App\Http\Controllers\CategoryLocationController;

// Admin
use App\Http\Controllers\Admin\PlatformInsightController;
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
        "middleware" => ["auth:api"],
    ], function () {
        // Chat
        Route::group(["prefix" => "chat"], function () {
            Route::post("/",    [ChatController::class, "handleUserMessage"]);
            Route::get("/",     [ChatController::class, "getChatHistory"]);
            Route::delete("/",  [ChatController::class, "deleteMessage"]);
        });

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

        // Orders
        Route::group(["prefix" => "orders"], function () {
            Route::post("/",     [ClientOrderController::class, "store"]);
            Route::get("/",      [ClientOrderController::class, "index"]);
            Route::get("/{id}",  [ClientOrderController::class, "show"]);
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

        // Favorites
        Route::group(["prefix" => "favorites"], function () {
            Route::post("/", [FavoriteController::class, "toggle"]);
        });

        // Tables (viewing)
        Route::group(["prefix" => "tables"], function () {
            Route::get("/", [CommonTableController::class, "index"]);
        });
    });

    // Owner endpoints
    Route::group([
        "prefix"     => "owner",
        "middleware" => ["auth:api", "owner.only"],
    ], function () {
        // Products
        Route::group(["prefix" => "product"], function () {
            Route::post("/",                [OwnerProductController::class, "store"]);
            Route::get("/{id}",             [OwnerProductController::class, "show"]);
            Route::put("/{id}",             [OwnerProductController::class, "update"]);
            Route::delete("/{id}",          [OwnerProductController::class, "destroy"]);

            Route::post("/{product}/locations",             [ProductLocationController::class, 'store']);
            Route::delete("/{product}/locations/{branch}",  [ProductLocationController::class, 'destroy']);
        });

        // Categories
        Route::group(["prefix" => "categories"], function () {
            Route::post("/",               [OwnerCategoryController::class, "store"]);
            Route::put("/{id}",            [OwnerCategoryController::class, "update"]);
            Route::delete("/{id}",         [OwnerCategoryController::class, "destroy"]);

            Route::post("/{category}/locations",             [CategoryLocationController::class, 'store']);
            Route::delete("/{category}/locations/{branch}",  [CategoryLocationController::class, 'destroy']);
        });

        // Tables
        Route::group(["prefix" => "tables"], function () {
            Route::post("/",              [OwnerTableController::class, "store"]);
            Route::put("/{tableId}",      [OwnerTableController::class, "update"]);
            Route::delete("/{tableId}",   [OwnerTableController::class, "destroy"]);
        });
    });

    // Admin endpoints
    Route::group([
        "prefix"     => "admin",
        "middleware" => ["auth:api", "admin.only"],
    ], function () {
        // Insights
        Route::group(['prefix' => 'platform-insights'], function () {
            Route::get('/',          [PlatformInsightController::class, 'index']);
            Route::get('/months',    [PlatformInsightController::class, 'months']);
            Route::post('/refresh',  [PlatformInsightController::class, 'refresh']);
        });

        // Restaurants
        Route::group(["prefix" => "restaurants"], function () {
            Route::post("/",        [AdminRestaurantController::class, "store"]);
            Route::put("/{id}",     [AdminRestaurantController::class, "update"]);
            Route::delete("/{id}",  [AdminRestaurantController::class, "destroy"]);
        });

        // Branches
        Route::group(["prefix" => "restaurant-locations"], function () {
            Route::post("/",        [AdminLocationController::class, "store"]);
            Route::put("/{id}",     [AdminLocationController::class, "update"]);
            Route::delete("/{id}",  [AdminLocationController::class, "destroy"]);
        });
    });
});
