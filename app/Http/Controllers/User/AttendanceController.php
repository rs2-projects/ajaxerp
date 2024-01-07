<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
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
        $this->setPageTitle("Attendance");
        $this->setActiveMenu('user.attendance');
        return  $this->view('user.attendance.index');
    }

    public function create(Request $request, AttendanceService $attendanceService)
    {

    }

    public function punch(Request $request, AttendanceService $attendanceService)
    {
        try {
          $data =  $attendanceService->punch($request);

          return $data;

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Attendance has been created successfully.');
    }
}
