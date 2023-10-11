<?php

namespace Josefo727\GeneralSettings\Console;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Filesystem\Filesystem;

class InstallGeneralSettings extends Command
{
    protected $signature = 'general-settings:install';
    protected $description = 'Install all necessary files for General Settings package';

    /**
     * @return void
     */
    public function handle(Filesystem $filesystem): void
    {
        // Publicar configuraciones, recursos y rutas
        Artisan::call('vendor:publish', ['--tag' => 'general-settings:config']);
        Artisan::call('vendor:publish', ['--tag' => 'general-settings:lang']);
        Artisan::call('vendor:publish', ['--tag' => 'general-settings:resources']);
        Artisan::call('vendor:publish', ['--tag' => 'general-settings:routes']);

        // Añadir el include en web.php si se ha publicado gs-web.php
        $webRoutePath = base_path('routes/web.php');
        $gsWebRoutePath = base_path('routes/gs-web.php');

        if ($filesystem->exists($gsWebRoutePath)) {
            $includeStatement = "include base_path('routes/gs-web.php');";
            $webRoutesContent = $filesystem->get($webRoutePath);

            if (strpos($webRoutesContent, $includeStatement) === false) {
                $filesystem->append($webRoutePath, PHP_EOL . $includeStatement);
                $this->info('Include statement added to web.php.');
            } else {
                $this->info('Include statement already exists in web.php.');
            }
        }

        $this->info('General Settings package installed successfully.');
    }
}

