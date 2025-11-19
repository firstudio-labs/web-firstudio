<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Profil;

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
        // Pastikan data profil tersedia di komponen global seperti navbar dan footer
        View::composer(['template_web.navbar', 'template_web.footer', 'components.chatbot'], function ($view) {
            static $profilCache = null;

            if ($profilCache === null) {
                $profilCache = Profil::first();
            }

            $view->with('profil', $profilCache);
        });
    }
}
