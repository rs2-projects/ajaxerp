<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hr\EmployeeAttendance\StoreBulkEmployeeAttendanceRequest;
use App\Http\Requests\Hr\EmployeeAttendance\StoreEmployeeAttendanceRequest;
use App\Services\Hr\EmployeeAttendanceService;
use Illuminate\Http\Request;

class EmployeeAttendanceController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Employee Attendance', route('hr.employee-attendance'));
    }

    public function index(Request $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        $this->setPageTitle("Employee Attendance");
        $this->setActiveMenu('hr.employee-attendance');
        $data = $employeeAttendanceService->indexData($request);
        return  $this->view('hr.employee-attendance.index')->with($data);
    }

    public function bulkAttendanceStore(StoreBulkEmployeeAttendanceRequest $request, EmployeeAttendanceService $employeeAttendanceService)
    {

        try {
            $employeeAttendanceService->bulkAttendanceStore($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function attendanceStore(StoreEmployeeAttendanceRequest $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        try {
            $employeeAttendanceService->attendanceStore($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Create Success");
    }
    public function getEmployeesByAttendanceDate(Request $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        try {
            $data = $employeeAttendanceService->getEmployeesByAttendanceDate($request);
            $view = $this->view('hr.employee-attendance._select_employee_data')->with($data)->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function getEmployeeAttendanceActivityDetailsByDate(Request $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        try {
            $data = $employeeAttendanceService->getEmployeeAttendanceActivityDetailsByDate($request);
            $html_view = $this->view('hr.employee-attendance._employee_attendance_activity_details')->with($data)->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['html_view' => $html_view, 'last_flag' => $data['last_flag']]);
    }

    public function getEmployeeAttendanceEditDetailsByDate(Request $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        try {
            $data = $employeeAttendanceService->getEmployeeAttendanceEditDetailsByDate($request);
            $html_view = $this->view('hr.employee-attendance._employee_attendance_edit_details')->with($data)->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['html_view' => $html_view]);
    }

    public function getEmployeeAttendanceEditDetailsByDateEditForm(Request $request, EmployeeAttendanceService $employeeAttendanceService)
    {
        try {
            $data = $employeeAttendanceService->getEmployeeAttendanceEditDetailsByDateEditForm($request);
            $html_view = $this->view('hr.employee-attendance._employee_attendance_edit_details_edit_form')->with($data)->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['html_view' => $html_view]);
    }

    public function getEmployeeAttendanceEditDetailsByDateUpdate(Request $request, $id, EmployeeAttendanceService $employeeAttendanceService)
    {

        try {
            $employeeAttendanceService->getEmployeeAttendanceEditDetailsByDateUpdate($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }
}
