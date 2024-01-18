<?php

namespace App\Http\Controllers\User;

use App\Helpers\AttendanceHelper;
use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\User\Attendance\StoreAttendanceRequest;
use App\Services\User\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('user.attendance'), 'fa fa-users');
        $this->addBreadcrumbs('Attendance');
    }

    public function index(Request $request, AttendanceService $attendanceService)
    {
//        AttendanceHelper::employeeAttendanceDetails(2, '2024-01-09');
        $this->setPageTitle("Attendance");
        $this->setActiveMenu('user.attendance');
        $data = $attendanceService->indexData($request);
        return  $this->view('user.attendance.index')->with($data);
    }

    public function create(Request $request, AttendanceService $attendanceService)
    {

    }

    public function punch(StoreAttendanceRequest $request, AttendanceService $attendanceService)
    {
        try {
            $attendanceService->punch($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Attendance has been created successfully.');
    }
}
