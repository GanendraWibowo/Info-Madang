<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;


class AuthServiceProvider extends ServiceProvider
{
    public function boot()
    {
        Gate::define('admin-access', function ($user) {
            // Logika validasi apakah user adalah admin
            return $user->role === 'admin'; // Sesuaikan dengan kolom role di database Anda
        });
    }
}
