<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\OverTime\StoreOverTimeTypeSettingsRequest;
use App\Http\Requests\Settings\OverTime\UpdateOverTimeTypeSettingsRequest;
use App\Services\Settings\OfficeTimeSettingsService;
use App\Services\Settings\OverTimeSettingsService;
use Illuminate\Http\Request;

class OverTimeSettingsController extends BackendController
{

    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Over Time');
    }
    public function showOverTimeSettings(OverTimeSettingsService $overTimeSettingsService)
    {
        $this->setPageTitle("Over Time");
        $this->setActiveMenu('settings.over-time');

        $data = $overTimeSettingsService->getIndexData();

        return $this->view('settings.over-time.index')->with($data);
    }

    public function storeOverTimeSettings(StoreOverTimeTypeSettingsRequest $request, OverTimeSettingsService $officeTimeSettingsService)
    {

        try {
            $officeTimeSettingsService->store($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        session()->flash('success', 'Create Success');
        return $this->returnAjaxSuccess([
            'status' => 200,
            'message' => 'Create Success',
        ], "Create Success");
    }

    public function edit(OverTimeSettingsService $overTimeSettingsService, $id)
    {
        $data = $overTimeSettingsService->getEditData($id);

        $view = $this->view('settings.over-time._edit_data')->with($data)
            ->render();
        return $this->returnAjaxSuccess([
            'view' => $view,
        ]);
    }

    public function update(UpdateOverTimeTypeSettingsRequest $request, OverTimeSettingsService $overTimeSettingsService, $id)
    {
        try {

            $overTimeSettingsService->update($request, $id);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        session()->flash('success', 'Update Success');
        return $this->returnAjaxSuccess([
            'status' => 200,
            'message' => 'Update Success',
        ], "Update Success");
    }

    public function delete(OverTimeSettingsService $overTimeSettingsService, $id)
    {
        try {

            $overTimeSettingsService->delete($id);

        } catch (\Exception $exception) {
            session()->flash('error', $exception->getMessage());
            return redirect()->back()->with('error', $exception->getMessage());
        }
        session()->flash('success', 'Delete Success');
        return redirect()->back()->with('success', 'Delete Success');
    }


}
