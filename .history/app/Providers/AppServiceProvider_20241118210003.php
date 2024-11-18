<<<<<<< HEAD
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

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
        Gate::define('admin-access', function ($user) {
            return $user->role === 'admin';
        });
    }
}
=======
//
>>>>>>> 2bf3adc0b7147f7469e04e940c0d1c217118e189
