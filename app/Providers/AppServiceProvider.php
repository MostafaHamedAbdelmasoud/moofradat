<?php

namespace App\Providers;

use App\Setting;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        if(config('app.env') === 'production' ) {
            \URL::forceScheme('https');
        }
        Schema::defaultStringLength(191);
        $settings = Setting::find(1);
        view::share('name', $settings->site_title);
        view::share('description', $settings->site_description);
        view::share('keywords', $settings->site_keywords);
        view::share('url', $settings->site_url);
        view::share('logo', $settings->site_logo);
        view::share('footer_text', $settings->site_footer_text);
        view::share('android_app', $settings->android_app);
        view::share('ios_app', $settings->ios_app);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
