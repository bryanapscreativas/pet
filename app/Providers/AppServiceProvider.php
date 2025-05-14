<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

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
        // Establecer el idioma para las validaciones
        Validator::includeUnvalidatedArrayKeys();
        
        // Asegurar que los mensajes de validación estén en español
        app('translator')->setLocale('es');
        
        // Configurar el formato de fechas en español
        setlocale(LC_TIME, 'es_ES.UTF-8');
        \Carbon\Carbon::setLocale('es');
    }
}
