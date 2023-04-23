<?php

namespace Josefo727\GeneralSettings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Josefo727\GeneralSettings\Models\GeneralSetting;
use Josefo727\GeneralSettings\Services\DataTypeService;

class GeneralSettingController extends Controller
{
    public function index(Request $request)
    {
        $types = app(DataTypeService::class)->getTypesForSelect();

        $settings = GeneralSetting::query()
            ->applyFilters($request)
            ->paginate(5);

        return view('general-settings::index', compact('settings', 'types'));
    }
    // ...
}
