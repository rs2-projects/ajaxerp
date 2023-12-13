<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\LeaveType\StoreLeaveTypeSettingsRequest;
use App\Http\Requests\Settings\LeaveType\UpdateLeaveTypeSettingsRequest;
use App\Services\Settings\LeaveTypeSettingsService;
use Illuminate\Http\Request;

class LeaveTypeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Leave Type');
    }

    public function index()
    {
        $this->setPageTitle("Leave Type");
        $this->setActiveMenu('settings.leave-type');

        return $this->view('settings.leave-type.index');
    }

    public function indexFiltered(Request $request, LeaveTypeSettingsService $leaveTypeSettingsService)
    {
        $data = $leaveTypeSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.leave-type._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreLeaveTypeSettingsRequest $request, LeaveTypeSettingsService $leaveTypeSettingsService)
    {

        try {
            $leaveTypeSettingsService->storeLeaveTypeSettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(LeaveTypeSettingsService $leaveTypeSettingsService, $id)
    {
        $data = $leaveTypeSettingsService->getEditData($id);

        $view = $this->view('settings.leave-type._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateLeaveTypeSettingsRequest $request, LeaveTypeSettingsService $leaveTypeSettingsService, $id)
    {
        try {
            $leaveTypeSettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([],"Update Success");
    }

    public function delete(LeaveTypeSettingsService $leaveTypeSettingsService, $id)
    {
        try {

            $leaveTypeSettingsService->delete($id);

        } catch (\Exception $exception) {

            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([],"Delete Success");
    }

    public function statusUpdate(LeaveTypeSettingsService $leaveTypeSettingsService, $id, $status)
    {
        try {

            $leaveTypeSettingsService->statusUpdate($id, $status);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([],"Status Update Success");
    }
}
