<?php

declare(strict_types=1);

namespace Frameworks\Laravel\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            Route::namespace('')
                ->group(base_path('frameworks/Laravel/Routes/Modules/Nicespace.php'));
            Route::namespace('')
                ->group(base_path('frameworks/Laravel/Routes/Modules/Product.php'));
            Route::namespace('')
                ->group(base_path('frameworks/Laravel/Routes/Modules/Monolith.php'));
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('api', static function (Request $request) {
            return Limit::perMinute(200)->by(
                $request->user()?->id ?: $request->ip()
            );
        });
    }
}
