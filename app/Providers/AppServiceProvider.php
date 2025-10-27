<?php

namespace App\Providers;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

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

        // ini kode nya biar engga error ketika buka aset aset nya di production
        \URL::forceRootUrl(config('app.url'));
        if (str_starts_with(config('app.url'), 'https://')) {
            \URL::forceScheme('https');
        }
        // Blade helper untuk single role (juga mendukung pipe "admin|superadmin")
        Blade::if('role', function ($role) {
            if (!auth()->check()) {
                return false;
            }
            $userRole = auth()->user()->role;
            if (is_string($role) && strpos($role, '|') !== false) {
                $roles = explode('|', $role);
                return in_array($userRole, $roles);
            }
            return $userRole === $role;
        });

        // Blade helper untuk multiple roles sebagai parameters: @roles('admin','superadmin')
        Blade::if('roles', function (...$roles) {
            if (!auth()->check())
                return false;
            return in_array(auth()->user()->role, $roles);
        });
    }
}
