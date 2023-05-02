<?php

namespace Josefo727\GeneralSettings\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Facade;
use Josefo727\GeneralSettings\Models\GeneralSetting;
use Illuminate\Contracts\Config\Repository;

class GeneralSettingsServiceProvider extends ServiceProvider
{
    public function boot(Repository $config): void
    {
        $this->mergeConfigFrom(__DIR__.'/../../' . 'config/general_settings.php', 'general_settings');

        $loadCrudWeb = $config->get('general_settings.crud_web.enable', false);
        $loadCrudApi = $config->get('general_settings.crud_api.enable', false);

        // Registra las migraciones y vistas si es necesario
        $this->loadMigrationsFrom(__DIR__ . '/../../' . 'database/migrations');
        if ($loadCrudWeb) {
            $this->loadRoutesFrom(__DIR__ . '/../../' . 'routes/web.php');
            $this->loadViewsFrom(__DIR__ . '/../../'. '/resources/views/general-settings', 'general-settings');
        }
        $this->loadTranslationsFrom(__DIR__. '/../../' . 'lang', 'general-settings');

        $this->publishes([
            __DIR__.'/../../' . 'config' => config_path(),
        ], 'general-settings:config');
        $this->publishes([
            __DIR__.'/../../' . 'lang' => base_path('lang'),
        ], 'general-settings:lang');
        $this->publishes([
            __DIR__.'/../../' . 'resources' => base_path('resources'),
        ], 'general-settings:resources');
    }

    public function register(): void
    {
        $this->app->register(ServiceProvider::class);
        $this->app->bind('general-setting', function(){
            return new GeneralSetting;
        });
        Facade::setFacadeApplication($this->app);
    }

}
