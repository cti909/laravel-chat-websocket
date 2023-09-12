<?php

namespace App\Providers;

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\ServiceProvider;

class BroadcastServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Broadcast::routes();
        // Broadcast::routes(['middleware' => ['auth:api']]);
        // Broadcast::routes(['middleware' => 'auth:admin']);
        Broadcast::routes(['prefix' => 'api/', 'middleware' => ['jwt.auth']]);

        require base_path('routes/channels.php');
    }
}
