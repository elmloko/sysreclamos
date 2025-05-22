<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;
use Illuminate\Support\Facades\Response;

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
        Gate::define('viewPulse', function (?User $user) {
            return $user !== null;
        });
        // 🔒 Agrega HttpOnly a XSRF-TOKEN (opcional, si NO lo usas con JavaScript)
        app('router')->middleware('web')->group(function () {
            app('events')->listen('Illuminate\Routing\Events\RouteMatched', function () {
                $token = csrf_token();
    
                Cookie::queue(
                    new SymfonyCookie(
                        'XSRF-TOKEN',
                        $token,
                        now()->addMinutes(config('session.lifetime')),
                        '/',
                        null,
                        config('session.secure'),
                        true, // HttpOnly
                        false,
                        'Lax'
                    )
                );
            });
        });
    }
}
