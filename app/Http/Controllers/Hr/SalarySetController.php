<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
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
}
