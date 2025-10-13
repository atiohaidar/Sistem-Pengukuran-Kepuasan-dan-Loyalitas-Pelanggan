<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // ini kode nya biar engga error ketika buka aset aset nya di production
        \URL::forceRootUrl(config('app.url'));
        if (str_starts_with(config('app.url'), 'https://')) {
            \URL::forceScheme('https');
        }
    }
}
