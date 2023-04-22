<?php

namespace Josefo727\GeneralSettings\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Facade;

class GeneralSettingsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        // $this->loadRoutesFrom(__DIR__.'/routes/web.php');
        // $this->loadRoutesFrom(__DIR__.'/routes/api.php');

        // $this->publishes([
        //     __DIR__.'/config/generalsettings.php' => config_path('generalsettings.php'),
        //     // Agrega más archivos de configuración si es necesario
        // ]);

        // Registra las migraciones y vistas si es necesario
        $this->loadMigrationsFrom(__DIR__.'/../../database/migrations');
        $this->mergeConfigFrom(__DIR__.'/../../config/general_settings.php', 'general_settings');
        // $this->loadViewsFrom(__DIR__.'/resources/views', 'generalsettings');

        $encryptionKey = Config::get('general_settings.encryption.key');
        $encrypter = new Encrypter($encryptionKey);
        Crypt::setFacadeApplication([
            'encrypter' => $encrypter,
        ]);
    }

    public function register()
    {
        $this->app->register(ServiceProvider::class);
        Facade::setFacadeApplication($this->app);
    }

}
