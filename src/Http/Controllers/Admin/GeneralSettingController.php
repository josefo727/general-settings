<?php

namespace Josefo727\GeneralSettings\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\View;
use Illuminate\Validation\ValidationException;
use Josefo727\GeneralSettings\Models\GeneralSetting;
use Josefo727\GeneralSettings\Services\DataTypeService;

class GeneralSettingController extends Controller
{
    /**
     * @param mixed $viewName
     * @return string
     */
    private function getView($viewName): string
    {
        $publishedView = "general-settings.$viewName";
        return View::exists($publishedView)
                ? $publishedView
                : "general-settings::$viewName";
    }

    /**
     * @param Request $request
     * @return View|Factory
     */
    public function index(Request $request)
    {
        $types = app(DataTypeService::class)->getTypesForSelect();

        $settings = GeneralSetting::query()
            ->applyFilters($request)
            ->paginate(5);

        $view = $this->getView('index');

        return view($view, compact('settings', 'types'));
    }

    /**
     * @return View|Factory
     * @param array $gs
     * @param array<int,mixed> $errors
     */
    public function create($gs = [], array $errors = [])
    {
        $generalSetting = new GeneralSetting($gs);

        $types = app(DataTypeService::class)->getTypesForSelect();

        $view = $this->getView('create');

        return view($view, compact('generalSetting', 'types', 'errors'));
    }

    /**
     * @param Request $request
     * @return View|Factory|RedirectResponse
     */
    public function store(Request $request)
    {
        try {
            // Try to create the model
            $data = $request->only(['name', 'value', 'description', 'type']);
            $generalSetting = GeneralSetting::create($data);
        } catch (ValidationException $e) {
            $gs = $request->all();
            $errors = $e->errors();
            return $this->create($gs, $errors);
        }

        return redirect()
            ->route('admin.general-settings.show', $generalSetting->id);
    }

    /**
     * @return View|Factory
     */
    public function show(int $id)
    {
        $generalSetting = GeneralSetting::query()->findOrFail($id);

        $view = $this->getView('show');

        return view($view, compact('generalSetting'));
    }

    /**
     * @param int $id
     * @param array $gs
     * @param array $errors
     * @return View|Factory
     */
    public function edit(int $id, array $gs = [], array $errors = [])
    {
        $types = app(DataTypeService::class)->getTypesForSelect();

        $generalSetting = GeneralSetting::query()->findOrFail($id);

        $generalSetting->fill($gs);

        $view = $this->getView('edit');

        return view($view, compact('generalSetting', 'types', 'errors'));
    }

    /**
     * @param Request $request
     * @param int $id
     * @return View|Factory|RedirectResponse
     */
    public function update(Request $request, int $id)
    {
        $generalSetting = GeneralSetting::query()->findOrFail($id);

        try {
            // Try to update the model
            $data = $request->only(['name', 'value', 'description', 'type']);
            $generalSetting = GeneralSetting::updateSetting($generalSetting, $data);
        } catch (ValidationException $e) {
            $gs = $request->all();
            $errors = $e->errors();
            return $this->edit($id, $gs, $errors);
        }

        return redirect()
            ->route('admin.general-settings.show', $generalSetting->id);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $generalSetting = GeneralSetting::query()->findOrFail($id);
        $generalSetting->delete();

        return redirect()
            ->route('admin.general-settings.index')
            ->with('success', __('general-settings::messages.delete_success_message'));
    }
}
