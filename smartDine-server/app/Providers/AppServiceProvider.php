<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureIsAdmin;
use App\Http\Middleware\EnsureIsOwner;
use App\Http\Middleware\EnsureOwns;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        Route::aliasMiddleware('admin.only', EnsureIsAdmin::class);
        Route::aliasMiddleware('owner.only', EnsureIsOwner::class);
        Route::aliasMiddleware('owner.owns', EnsureOwns::class);
    }
}
