<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\Employee\StoreEmployeeRequest;
use App\Http\Requests\Hr\Employee\UpdateBankInfoRequest;
use App\Http\Requests\Hr\Employee\UpdateEducationInfoRequest;
use App\Http\Requests\Hr\Employee\UpdateEmergencyContactRequest;
use App\Http\Requests\Hr\Employee\UpdateEmployeeRequest;
use App\Http\Requests\Hr\Employee\UpdateExperienceInfoRequest;
use App\Http\Requests\Hr\Employee\UpdatePersonalInfoRequest;
use App\Http\Requests\Hr\Employee\UpdateProfileInfoRequest;
use App\Services\Hr\EmployeeService;
use App\Services\Hr\UserLeavesService;
use App\Services\User\LeavesService;
use Illuminate\Http\Request;

class EmployeeController extends BackendController
{
    private EmployeeService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Employee', route('hr.employee'));
        $this->service = new EmployeeService();
    }

    public function index(EmployeeService $employeeService)
    {
        $this->setPageTitle("Employee");
        $this->setActiveMenu('hr.employee');
        $data = $employeeService->indexData();

        return  $this->view('hr.employee.index')->with($data);
    }

    public function indexFiltered(Request $request, EmployeeService $employeeService)
    {
        $data = $employeeService->getIndexFilteredData($request);
        $view = $this->view('hr.employee._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create(EmployeeService $employeeService)
    {
        $this->addBreadcrumbs('Create');
        $this->setPageTitle("Create Employee");
        $this->setActiveMenu('hr.employee.create');
        $data = $employeeService->getCreateData();

        return $this->view('hr.employee.create')->with($data);
    }

    public function store(StoreEmployeeRequest $request, EmployeeService $employeeService)
    {
        try {
            $employeeService->storeEmployee($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(EmployeeService $employeeService, $id)
    {
        try {
            $this->addBreadcrumbs('Edit');
            $this->setPageTitle("Edit Employee");
            $this->setActiveMenu('hr.employee.edit');
            $data = $employeeService->getEditData($id);
        }catch (\Exception $exception) {
            return redirect()->route('hr.employee')->with('error', $exception->getMessage());
        }

        return $this->view('hr.employee.edit')->with($data);
    }

    public function update(UpdateEmployeeRequest $request, EmployeeService $employeeService, $id)
    {
        try {
            $employeeService->updateEmployee($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function details(EmployeeService $employeeService, $id)
    {
        try {
            $this->addBreadcrumbs('Details');
            $this->setPageTitle("Employee Details");
            $this->setActiveMenu('hr.employee.details');
            $data = $employeeService->getDetailsData($id);
        }catch (\Exception $exception) {
            return redirect()->route('hr.employee')->with('error', $exception->getMessage());
        }
        // return $data;
        return $this->view('hr.employee.details')->with($data);
    }

    public function detailFiltered(Request $request, EmployeeService $employeeService, $id)
    {
        $data = $employeeService->getDetailFilteredData($request, $id);
        $view = $this->view('hr.employee._details')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function profileInfoUpdate(UpdateProfileInfoRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updateProfileInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");

    }

    public function personalInfoUpdate(UpdatePersonalInfoRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updatePersonalInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function bankInfoUpdate(UpdateBankInfoRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updateBankInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function educationInfoUpdate(UpdateEducationInfoRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updateEducationInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function experienceInfoUpdate(UpdateExperienceInfoRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updateExperienceInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function emergencyContactInfoUpdate(UpdateEmergencyContactRequest $request, EmployeeService $employeeService, $id)
    {

        try {
            $employeeService->updateEmergencyContactInfo($request,$id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(EmployeeService $employeeService, $id)
    {
        try {
            $employeeService->deleteEmployee($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Delete Success");
    }

    // public function editRole()
    // {
    //     try {
    //         $this->addBreadcrumbs('Edit');
    //         $this->setPageTitle("Edit Employee");
    //         $this->setActiveMenu('hr.employee.edit');
    //         $data = $employeeService->getEditData($id);
    //     }catch (\Exception $exception) {
    //         return redirect()->route('hr.employee')->with('error', $exception->getMessage());
    //     }

    //     return $this->view('hr.employee.edit')->with($data);
    // }

    // public function updateRole()
    // {
    //     try {
    //         $employeeService->updateEmployee($request, $id);
    //     }catch (\Exception $exception) {
    //         return $this->returnAjaxException($exception);
    //     }

    //     return $this->returnAjaxSuccess([], "Update Success");
    // }

    public function changeRole($id)
    {
        try {
            $data = $this->service->changeRoleData($id);
            $view = $this->view('hr.employee._change_role_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function updateRole(Request $request, $id)
    {
        try {
            $this->service->updateRole($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'User Role updated successfully');
    }

    public function getUserLeaveNumberOfDays(Request $request, LeavesService $leavesService)
    {
        try {
            $data = $leavesService->getUserLeaveNumberOfDays($request);
            return $this->returnAjaxSuccess($data);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }

    public function storeEmpLeave(Request $request)
    {
        try {
            $this->service->storeEmpLeave($request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been created successfully.');
    }
}
