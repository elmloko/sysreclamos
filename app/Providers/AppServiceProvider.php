<?php

namespace App\Providers;


use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\App;
use App\Models\User;


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
        if (App::environment('local')) {
            // Lista de comandos que quieres deshabilitar en producción
            $restrictedCommands = [
                'migrate:fresh',
                'migrate:reset',
                'db:wipe',
            ];

            Artisan::command($restrictedCommands, function () {
                $this->error("Este comando está deshabilitado en producción.");
            })->describe('Comando deshabilitado en producción.');
        }
    }
}
