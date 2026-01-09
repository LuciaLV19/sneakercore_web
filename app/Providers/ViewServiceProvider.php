<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('layouts.navigation', function ($view) {
            $allCategories = Category::all();
            $view->with([
                'genders' => $allCategories->where('type', 'gender'),
                'brands'  => $allCategories->where('type', 'brand'),
                'usages'  => $allCategories->where('type', 'usage'),
            ]);
        });
    }
}
