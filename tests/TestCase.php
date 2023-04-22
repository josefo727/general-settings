<?php

namespace Josefo727\GeneralSettings\Tests;

use Josefo727\GeneralSettings\Providers\GeneralSettingsServiceProvider;
use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    protected function getPackageProviders($app)
    {
        return [GeneralSettingsServiceProvider::class];
    }

    // public function createApplication()
    // {
    //     putenv('DB_SCHEMA=public');
    // }
}
