<?php

namespace App\Services\Settings;

use App\Models\SettingsLeaveType;
use Carbon\Carbon;

class LeaveTypeSettingsService
{

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $data['leaveTypes'] = SettingsLeaveType::where('deleted', SettingsLeaveType::DELETED_NO)
            ->orderBy('title', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }
    public function storeLeaveTypeSettings($request)
    {
        try {
            $leaveType = new SettingsLeaveType();
            $leaveType->title = $request->title;
            $leaveType->description = $request->description;
            $leaveType->annual_leave_days = $request->annual_leave_days;
            $leaveType->max_leave_per_month = $request->max_leave_per_month;
            $leaveType->salary_type = $request->salary_type;
            $leaveType->rate = $request->rate;
            $leaveType->created_by = auth()->id();
            $leaveType->created_at = Carbon::now();
            $leaveType->save();
        }catch (\Exception $exception) {
            throw new \Exception($exception->getMessage());
        }
    }

    public function getEditData($id)
    {
        $data['item'] = SettingsLeaveType::findOrFail($id);
        return $data;
    }

    public function update($request, $id)
    {
        try {
            $leaveType = SettingsLeaveType::findOrFail($id);
            $leaveType->title = $request->title;
            $leaveType->description = $request->description;
            $leaveType->annual_leave_days = $request->annual_leave_days;
            $leaveType->max_leave_per_month = $request->max_leave_per_month;
            $leaveType->salary_type = $request->salary_type;
            $leaveType->rate = $request->rate;
            $leaveType->updated_by = auth()->id();
            $leaveType->updated_at = Carbon::now();
            $leaveType->save();

        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $leaveType = SettingsLeaveType::findOrFail($id);
            $leaveType->deleted = SettingsLeaveType::DELETED_YES;
            $leaveType->status = SettingsLeaveType::STATUS_INACTIVE;
            $leaveType->deleted_at = Carbon::now();
            $leaveType->deleted_by = auth()->id();
            $leaveType->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $leaveType = SettingsLeaveType::findOrFail($id);
            $leaveType->status = $status;
            $leaveType->updated_by = auth()->id();
            $leaveType->updated_at = Carbon::now();
            $leaveType->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
