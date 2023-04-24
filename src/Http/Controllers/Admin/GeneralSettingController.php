<?php

namespace Josefo727\GeneralSettings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\ValidationException;
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

    public function create()
    {
        $types = app(DataTypeService::class)->getTypesForSelect();

        return view('general-settings::create', compact('types'));
    }

    public function store(Request $request)
    {
        try {
            // Try to create the model
            $data = $request->only(['name', 'value', 'description', 'type']);
            $generalSetting = GeneralSetting::create($data);
        } catch (ValidationException $e) {
            // Catches validation exception and sends error messages to view
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()
            ->route('admin.general-settings.show', $generalSetting->id);
    }

    public function show(int $id)
    {
        $generalSetting = GeneralSetting::findOrFail($id);

        return view('general-settings::show', compact('generalSetting'));
    }

    public function edit(int $id)
    {
        $types = app(DataTypeService::class)->getTypesForSelect();

        $generalSetting = GeneralSetting::findOrFail($id);

        return view('general-settings::edit', compact('generalSetting', 'types'));
    }

    public function update(Request $request, int $id)
    {
        $generalSetting = GeneralSetting::findOrFail($id);

        try {
            // Try to update the model
            $data = $request->only(['name', 'value', 'description', 'type']);
            $generalSetting = GeneralSetting::updateSetting($generalSetting, $data);
        } catch (ValidationException $e) {
            // Catches validation exception and sends error messages to view
            return redirect()->back()->withErrors($e->errors())->withInput();
        }

        return redirect()
            ->route('admin.general-settings.show', $generalSetting->id);
    }

    public function destroy(int $id)
    {
        $generalSetting = GeneralSetting::findOrFail($id);
        $generalSetting->delete();

        return redirect()
            ->route('admin.general-settings.index')
            ->with('success', __('general-settings::messages.delete_success_message'));
    }
}
