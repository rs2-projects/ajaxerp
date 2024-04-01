<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Models\Designation;
use App\Services\Ajax\AjaxService;
use Illuminate\Http\Request;

class AjaxController extends BackendController
{
    public function getDesignationByDepartment(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getDesignationByDepartment($request);
            $view = $this->view('ajax._get_designation_by_department')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxError($exception->getMessage());
        }
    }

    public function getDesignationByMultipleDepartments(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getDesignationByMultipleDepartments($request);
            $view = $this->view('ajax._get_designation_by_department')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxError($exception->getMessage());
        }
    }

    public function getEmployees(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getEmployees($request);
           return $this->returnAjaxSuccess($data);
        }catch (\Exception $exception) {
            return $this->returnAjaxError($exception->getMessage());
        }
    }
    public function salarySetGetEmployees(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->salarySetGetEmployees($request);
           return $this->returnAjaxSuccess($data);
        }catch (\Exception $exception) {
            return $this->returnAjaxError($exception->getMessage());
        }
    }

    public function getLeaveTypeByUser(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getLeaveTypeByUser($request);

            $view = $this->view('ajax._get_leave_type_by_user')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }

    public function getEmployeeTotalLeaveByLeaveType(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getEmployeeTotalLeaveByLeaveType($request);


            return $this->returnAjaxSuccess(['data' => $data]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }
    public function getEmployeeTotalLeaveByLeaveTypeEdit(Request $request, AjaxService $ajaxService)
    {
        try {
            $data = $ajaxService->getEmployeeTotalLeaveByLeaveTypeEdit($request);


            return $this->returnAjaxSuccess(['data' => $data]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }
}
