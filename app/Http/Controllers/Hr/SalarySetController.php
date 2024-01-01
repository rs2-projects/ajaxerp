<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\SalarySet\StoreSalarySetRequest;
use App\Http\Requests\Hr\SalarySet\UpdateSalarySetRequest;
use App\Services\Hr\SalarySetService;
use Illuminate\Http\Request;

class SalarySetController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Salary Set', route('hr.salary-set'));
    }
    public function index(Request $request, SalarySetService $salarySetService)
    {
        $this->setPageTitle("Salary Set");
        $this->setActiveMenu('hr.salary-set');

        /*$data = $salarySetService->indexData($request);*/

        return  $this->view('hr.salary-set.index');
    }

    public function indexFiltered(Request $request, SalarySetService $salarySetService)
    {
        $data = $salarySetService->getIndexFilteredData($request);
        $view = $this->view('hr.salary-set._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create(SalarySetService $salarySetService)
    {
        $this->addBreadcrumbs('Create');
        $this->setPageTitle("Create Salary Set");
        $this->setActiveMenu('hr.salary-set.create');
        $data = $salarySetService->getCreateData();

        return $this->view('hr.salary-set.create')->with($data);
    }

    public function store(StoreSalarySetRequest $request, SalarySetService $salarySetService)
    {
        /*return $request->all();*/
        try {
           $data = $salarySetService->store($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess($data, "Create Success");
    }

    public function edit($id, SalarySetService $salarySetService)
    {
        try {

            $data = $salarySetService->getEditData($id);

            $view = $this->view('hr.salary-set._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);

    }

    public function update($id, UpdateSalarySetRequest $request, SalarySetService $salarySetService)
    {
        try {
            $salarySetService->update($id, $request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete($id, SalarySetService $salarySetService)
    {
        try {
            $salarySetService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Delete Success");
    }

    public function attendanceSetEdit($id, SalarySetService $salarySetService)
    {
        try {

            $data = $salarySetService->getAttendanceSetEditData($id);

            $view = $this->view('hr.salary-set._edit_attendance_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);

    }

    public function attendanceSetUpdate($id, Request $request, SalarySetService $salarySetService)
    {
        try {
            $salarySetService->attendanceSetUpdate($id, $request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }


    public function leaveTypeSetEdit($id, SalarySetService $salarySetService)
    {
        try {

            $data = $salarySetService->getLeaveTypeSetEditData($id);

            $view = $this->view('hr.salary-set._edit_leave_type_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);

    }

    public function leaveTypeSetUpdate($id, Request $request, SalarySetService $salarySetService)
    {
        try {
            $salarySetService->leaveTypeSetUpdate($id, $request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function setEmployees($id, SalarySetService $salarySetService)
    {
        try {

            $this->addBreadcrumbs('Set Employees');
            $this->setPageTitle("Set Employees");
            $this->setActiveMenu('hr.salary-set.set-employees');

            $data = $salarySetService->getSetEmployeesData($id);
            return $this->view('hr.salary-set.set-employees')->with($data);
        }catch (\Exception $exception) {
            return redirect()->route('hr.salary-set')->with('error', $exception->getMessage());
        }
    }

    public function setEmployeesStore($id, Request $request, SalarySetService $salarySetService)
    {
        try {
            $salarySetService->setEmployeesStore($id, $request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([], "Set Employees Success");
    }
}
