<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\absentPenalty\StoreAbsentPenaltySettingsRequest;
use App\Http\Requests\Settings\absentPenalty\UpdateAbsentPenaltySettingsRequest;
use App\Services\Settings\AbsentPenaltySettingsService;
use Illuminate\Http\Request;

class AbsentPenaltySettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Absent Penalty');
    }
    public function index()
    {
        $this->setPageTitle("Absent Penalty");
        $this->setActiveMenu('settings.absent-penalty');

       return  $this->view('settings.absent-penalty.index');
    }

    public function indexFiltered(Request $request, AbsentPenaltySettingsService $absentPenaltySettingsService)
    {
        $data = $absentPenaltySettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.absent-penalty._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreAbsentPenaltySettingsRequest $request, AbsentPenaltySettingsService $absentPenaltySettingsService)
    {
        try {
            $absentPenaltySettingsService->storeAbsentPenaltySettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(AbsentPenaltySettingsService $absentPenaltySettingsService, $id)
    {
        $data = $absentPenaltySettingsService->getEditData($id);

        $view = $this->view('settings.absent-penalty._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateAbsentPenaltySettingsRequest $request, AbsentPenaltySettingsService $absentPenaltySettingsService, $id)
    {
        try {
            $absentPenaltySettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(AbsentPenaltySettingsService $absentPenaltySettingsService, $id)
    {
        try {
            $absentPenaltySettingsService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
