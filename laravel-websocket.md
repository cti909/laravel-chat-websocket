# laravel
## Install && Configuration - use pusher
1. link: https://beyondco.de/docs/laravel-websockets/getting-started/installation
  * composer require beyondcode/laravel-websockets
  * php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="migrations"
  * php artisan migrate
  * php artisan vendor:publish --provider="BeyondCode\LaravelWebSockets\WebSocketsServiceProvider" --tag="config"
2. Pusher Configuration
  * config/app: providers -> App\Providers\BroadcastServiceProvider::class,
  * config/broadcasting: edit connections -> pusher
    'pusher' => [
            'driver' => 'pusher',
            'key' => env('PUSHER_APP_KEY'),
            'secret' => env('PUSHER_APP_SECRET'),
            'app_id' => env('PUSHER_APP_ID'),
            'options' => [
                'cluster' => env('PUSHER_APP_CLUSTER'),
                'host' => env('PUSHER_HOST') ?: 'api-' . env('PUSHER_APP_CLUSTER', 'mt1') . '.pusher.com',
                'port' => env('PUSHER_PORT', 443),
                'scheme' => env('PUSHER_SCHEME', 'https'),
                'encrypted' => false,
                'useTLS' => false,
                // 'useTLS' => env('PUSHER_SCHEME', 'https') === 'https',
            ],
            'client_options' => [
                // Guzzle client options: https://docs.guzzlephp.org/en/stable/request-options.html
            ],
        ],
  * 



//react






