<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Models\SettingsSalarySet;
use Illuminate\Http\Request;

class GenerateSalaryController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Generate Salary');
    }

    public function index(Request $request)
    {
        $this->setPageTitle("Generate Salary");
        $this->setActiveMenu('hr.generate-salary');

        $data['months'] = config('commonData.month_names');

        return $this->view('hr.generate-salary.index')->with($data);
    }

    public function create(Request $request)
    {
        return redirect()->back()->with(['success' => 'Salary Generated Successfully']);
    }

    public function salaryList()
    {
        $this->setPageTitle("Salary List");
        $this->setActiveMenu('hr.generate-salary.salary-list');

        return $this->view('hr.generate-salary.salary-list');
    }

    public function getSalarySetBySalaryType(Request $request)
    {

        $settingsSalarySets = SettingsSalarySet::where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('salary_generate_type', $request->salary_type)
            ->get();

        $data = $this->view('hr.generate-salary._salary_set')->with(['settingsSalarySets' => $settingsSalarySets])->render();

        return $this->returnAjaxSuccess(['data' => $data]);
    }
}
