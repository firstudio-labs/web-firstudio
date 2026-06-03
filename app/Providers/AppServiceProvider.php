<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Profil;
use App\Models\Setting;

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
                $profilCache = Profil::first() ?? new Profil();
            }

            $view->with('profil', $profilCache);
        });

        View::composer(
            ['template_web.layout', 'template_web.layout-ads', 'components.web.meta-pixel'],
            function ($view) {
                static $metaPixelCache = null;

                if ($metaPixelCache === null) {
                    $metaPixelCache = [
                        'id' => Setting::where('key', 'meta_pixel_id')->value('value'),
                        'enabled' => Setting::where('key', 'meta_pixel_enabled')->value('value') === '1',
                        'scope' => Setting::where('key', 'meta_pixel_scope')->value('value') ?? 'ads_only',
                    ];
                }

                $view->with('metaPixel', $metaPixelCache);
            }
        );
    }
}
