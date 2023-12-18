<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\LatePenalty\StoreLatePenaltySettingsRequest;
use App\Http\Requests\Settings\LatePenalty\UpdateLatePenaltySettingsRequest;
use App\Services\Settings\LatePenaltySettingsService;
use Illuminate\Http\Request;

class LatePenaltySettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Late Penalty');
    }
    public function index()
    {
        $this->setPageTitle("Late Penalty");
        $this->setActiveMenu('settings.late-penalty');

       return  $this->view('settings.late-penalty.index');
    }

    public function indexFiltered(Request $request, LatePenaltySettingsService $latePenaltySettingsService)
    {
        $data = $latePenaltySettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.late-penalty._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreLatePenaltySettingsRequest $request, LatePenaltySettingsService $latePenaltySettingsService)
    {
        try {
            $latePenaltySettingsService->storeLatePenaltySettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(LatePenaltySettingsService $absentPenaltySettingsService, $id)
    {
        $data = $absentPenaltySettingsService->getEditData($id);

        $view = $this->view('settings.late-penalty._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateLatePenaltySettingsRequest $request, LatePenaltySettingsService $latePenaltySettingsService, $id)
    {
        try {
            $latePenaltySettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(LatePenaltySettingsService $latePenaltySettingsService, $id)
    {
        try {
            $latePenaltySettingsService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
