<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Hr\EmployeeService;
use Illuminate\Http\Request;

class EmployeeController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Employee', route('hr.employee'));
    }

    public function index(Request $request, EmployeeService $employeeService)
    {
        $this->setPageTitle("Employee");
        $this->setActiveMenu('hr.employee');

        /*$data = $employeeService->indexData($request);*/

        return  $this->view('hr.employee.index');
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
}
