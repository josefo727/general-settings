<?php

use Josefo727\GeneralSettings\Http\Controllers\Admin\GeneralSettingController;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;

Route::middleware([Config::get('general_settings.crud_web.middleware')])->group(function () {
    Route::resource('/admin/general-settings', GeneralSettingController::class)
        ->names([
            'index' => 'admin.general-settings.index',
            'create' => 'admin.general-settings.create',
            'store' => 'admin.general-settings.store',
            'show' => 'admin.general-settings.show',
            'edit' => 'admin.general-settings.edit',
            'update' => 'admin.general-settings.update',
            'destroy' => 'admin.general-settings.destroy',
        ]);
});
