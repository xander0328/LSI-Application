<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class FirebaseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(\Kreait\Firebase::class, function ($app) {
            return (new Factory)
                ->withServiceAccount(config('services.firebase.credentials')) // You may point to your env file
                ->create();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
