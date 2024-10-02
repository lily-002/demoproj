<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
         $this->app->register(\L5Swagger\L5SwaggerServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         ResetPassword::createUrlUsing(function (User $user, string $token) {
        return 'https://dashboard.econiasoft.com/auth/reset-password?token='.$token.'&email='.$user->email;
    });
    }
}
