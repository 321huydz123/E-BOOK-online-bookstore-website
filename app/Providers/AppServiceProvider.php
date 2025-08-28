<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

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
        //
        $filePath = public_path('admin/js/seo.json');
        $scripts = [];
        if (file_exists($filePath)) {
            $scripts = json_decode(file_get_contents($filePath), true);
        }
        // dd($scripts);
        View::share('scripts_seo', $scripts);


        $filePath = public_path('admin/js/config.json');
        $configData = [];
        if (file_exists($filePath)) {
            $configData = json_decode(file_get_contents($filePath), true);
        }
        // dd($scripts);
        View::share('configData', $configData);
    }
}
