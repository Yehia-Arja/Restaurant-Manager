<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Common\MediaService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind MediaService as a singleton, preconfigured for S3/products
        $this->app->singleton(MediaService::class, function ($app) {
            return new MediaService('s3', 'products');
        });
    }

    public function boot()
    {
        //
    }
}
