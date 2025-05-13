<?php
<<<<<<< HEAD

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use App\Models\Product;
use App\Models\Category;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
     public function boot(): void
    {

    }
=======
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\Common\MediaService;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
    }

    public function boot()
    {
        //
    }
>>>>>>> 2b890721c062469001e41f7995fc9c4c496a783d
}
