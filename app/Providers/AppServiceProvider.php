<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use App\Models\Brand;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Inject $menuBrands cho mọi view
        View::composer('*', function ($view) {
            $menuBrands = Cache::remember('menu_brands', 3600, function () {
                return Brand::orderBy('name')->get(['name', 'slug']);
            });

            $view->with('menuBrands', $menuBrands);
        });
    }
}
