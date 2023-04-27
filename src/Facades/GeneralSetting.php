<?php

namespace Josefo727\GeneralSettings\Facades;

use Illuminate\Support\Facades\Facade;

class GeneralSetting extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'general-setting';
    }
}
