<?php

namespace App\Http\Controllers\Payroll;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Models\Salary;
use App\Models\SalarySettingsSalarySets;
use App\Models\SettingsBonusType;
use App\Models\SettingsSalaryDeductionType;
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
        try {
            $this->service->generateSalary($request);
        } catch (\Exception $exception) {
            return redirect()->back()->with(['failed' => $exception->getMessage()]);
        }

        return redirect()->back()->with(['success' => 'Salary Generated Successfully']);
    }

    public function salaryList()
    {
        $this->setPageTitle("Salary List");
        $this->setActiveMenu('payroll.generate-salary.salary-list');

        return $this->view('payroll.generate-salary.salary-list');
    }

    public function getSalaryGenerateDetails(Request $request)
    {
        $salary_ids = Salary::where('salary_year', $request->year)
            ->where('salary_month', $request->month)
            ->where('salary_generate_type', $request->salary_type)
            ->where('salary_period', $request->period_type ?? Salary::SALARY_PERIOD_FULL_MONTH)
            ->pluck('id')
            ->toArray();

        $generated_salary_set_ids = SalarySettingsSalarySets::whereIn('salary_id', $salary_ids)
            ->pluck('settings_salary_set_id')
            ->toArray();


        $data['settingsSalarySets'] = SettingsSalarySet::where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->whereNotIn('id', $generated_salary_set_ids)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('salary_generate_type', $request->salary_type)
            ->get();

        $data['bonusTypes'] = SettingsBonusType::where('status', SettingsBonusType::STATUS_ACTIVE)
            ->where('deleted', SettingsBonusType::DELETED_NO)
            ->get();
        $data['deductionTypes'] = SettingsSalaryDeductionType::where('status', SettingsSalaryDeductionType::STATUS_ACTIVE)
            ->where('deleted', SettingsSalaryDeductionType::DELETED_NO)
            ->get();

        $data['salary_type'] = Salary::SALARY_GENERATE_TYPES[$request->salary_type];
        if($request->period_type != '') {
            $data['period_type'] = Salary::SALARY_PERIODS[$request->period_type] ?? 'Full Month';
        } else {
            $data['period_type'] = 'Full Month';
        }
        $data['month_name'] = config('commonData.month_names')[$request->month];
        $data['year'] = $request->year;

        $view = $this->view('payroll.generate-salary._salary_generate_details')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['data' => $view]);
    }

    public function getSalarySetBySalaryType(Request $request)
    {

        $data['settingsSalarySets'] = SettingsSalarySet::where('status', SettingsSalarySet::STATUS_ACTIVE)
            ->where('deleted', SettingsSalarySet::DELETED_NO)
            ->where('salary_generate_type', $request->salary_type)
            ->get();

        $this->view('payroll.generate-salary._salary_set')
            ->with($data)->render();

        return $this->returnAjaxSuccess(['data' => $data]);
    }
}
