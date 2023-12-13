<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\Holiday\StoreHolidaySettingsRequest;
use App\Http\Requests\Settings\Holiday\UpdateHolidaySettingsRequest;
use App\Services\Settings\HolidaySettingsService;
use Illuminate\Http\Request;

class HolidaySettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Holiday');
    }

    public function index()
    {
        $this->setPageTitle("Holiday");
        $this->setActiveMenu('settings.holiday');

        return $this->view('settings.holiday.index');
    }

    public function indexFiltered(Request $request, HolidaySettingsService $holidaySettingsService)
    {
        $data = $holidaySettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.holiday._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreHolidaySettingsRequest $request, HolidaySettingsService $holidaySettingsService)
    {

        try {
            $holidaySettingsService->storeHolidaySettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(HolidaySettingsService $holidaySettingsService, $id)
    {
        $data = $holidaySettingsService->getEditData($id);

        $view = $this->view('settings.holiday._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateHolidaySettingsRequest $request, HolidaySettingsService $holidaySettingsService, $id)
    {
        try {
            $holidaySettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([],"Update Success");
    }

    public function delete(HolidaySettingsService $holidaySettingsService, $id)
    {
        try {

            $holidaySettingsService->delete($id);

        } catch (\Exception $exception) {

            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([],"Delete Success");
    }
}
