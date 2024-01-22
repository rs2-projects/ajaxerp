<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Models\SettingsSalarySet;
use App\Services\Payroll\GenerateSalaryService;
use Illuminate\Http\Request;

class GenerateSalaryController extends BackendController
{
    private GenerateSalaryService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Generate Salary');

        $this->service = new GenerateSalaryService();
    }

    public function index(Request $request)
    {
        $this->setPageTitle("Generate Salary");
        $this->setActiveMenu('payroll.generate-salary');

        $data = $this->service->getIndexData($request);

        return $this->view('payroll.generate-salary.index')->with($data);
    }

    public function create(Request $request)
    {
        $this->service->generateSalary($request);
    }

    public function salaryList()
    {
        $this->setPageTitle("Salary List");
        $this->setActiveMenu('payroll.generate-salary.salary-list');

        return $this->view('payroll.generate-salary.salary-list');
    }

    public function getSalarySetBySalaryType(Request $request)
    {

        $settingsSalarySets = SettingsSalarySet::where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('salary_generate_type', $request->salary_type)
            ->get();

        $data = $this->view('payroll.generate-salary._salary_set')->with(['settingsSalarySets' => $settingsSalarySets])->render();

        return $this->returnAjaxSuccess(['data' => $data]);
    }
}
