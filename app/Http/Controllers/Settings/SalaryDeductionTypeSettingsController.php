<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Settings\SalaryDeductionTypeSettingsService;
use Illuminate\Http\Request;

class SalaryDeductionTypeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Salary Deduction Type');
    }

    public function index(SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        $this->setPageTitle("Salary Deduction Type");
        $this->setActiveMenu('settings.salary-deduction-type');


        return $this->view('settings.salary-deduction-type.index');
    }

    public function indexFiltered(Request $request, SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        $data = $salaryDeductionTypeSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.salary-deduction-type._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }
}
