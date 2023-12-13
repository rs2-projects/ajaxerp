<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\OfficeTime\StoreOfficeTimeSettingsRequest;
use App\Http\Requests\Settings\OfficeTime\UpdateOfficeTimeSettingsRequest;
use App\Models\SettingsOfficeTimeType;
use App\Services\Settings\OfficeTimeSettingsService;
use Illuminate\Http\Request;

class OfficeTimeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Office Time');
    }
    public function showOfficeTimeSettings(OfficeTImeSettingsService $officeTimeSettingsService)
    {
        $this->setPageTitle("Office Time");
        $this->setActiveMenu('settings.office-time');

        $data = $officeTimeSettingsService->getIndexData();

        return $this->view('settings.office-time.index')->with($data);
    }

    public function filteredOfficeTimeSettings(Request $request, OfficeTimeSettingsService $officeTimeSettingsService)
    {
        $data = $officeTimeSettingsService->getIndexFilteredData($request);

        $view = $this->view('settings.office-time._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function storeOfficeTimeSettings(StoreOfficeTimeSettingsRequest $request, OfficeTimeSettingsService $officeTimeSettingsService)
    {

        try {

            $officeTimeSettingsService->store($request);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        /*session()->flash('success', 'Create Success');*/
        return $this->returnAjaxSuccess([
            'status' => 200,
            'message' => 'Create Success',
        ], "Create Success");
    }

    public function edit(OfficeTimeSettingsService $officeTimeSettingsService , $id)
    {
        $data = $officeTimeSettingsService->getEditData($id);

        $view = $this->view('settings.office-time._edit_data')->with($data)
            ->render();
        return $this->returnAjaxSuccess([
            'view' => $view,
        ]);
    }

    public function update(UpdateOfficeTimeSettingsRequest $request, OfficeTimeSettingsService $officeTimeSettingsService, $id)
    {
        try {

            $officeTimeSettingsService->update($request, $id);

        } catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        session()->flash('success', 'Update Success');
        return $this->returnAjaxSuccess([
            'status' => 200,
            'message' => 'Update Success',
        ], "Update Success");
    }

    public function delete(OfficeTimeSettingsService $officeTimeSettingsService, $id)
    {
        try {

            $officeTimeSettingsService->delete($id);

        } catch (\Exception $exception) {

            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
//        session()->flash('success', 'Delete Success');
//        return redirect()->back()->with('success', 'Delete Success');
    }

}
