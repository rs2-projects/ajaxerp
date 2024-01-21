<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\SalaryDeductionType\StoreSalaryDeductionTypeRequest;
use App\Http\Requests\Settings\SalaryDeductionType\UpdateSalaryDeductionTypeRequest;
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

    public function store(StoreSalaryDeductionTypeRequest $request, SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        try {
            $salaryDeductionTypeSettingsService->storeSalaryDeductionTypeSettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit($id, SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        try {
            $data = $salaryDeductionTypeSettingsService->getEditData($id);
            $view = $this->view('settings.salary-deduction-type._edit_data')->with($data)->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }

    public function update(UpdateSalaryDeductionTypeRequest $request, $id, SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        try {
            $salaryDeductionTypeSettingsService->updateSalaryDeductionTypeSettings($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete($id, SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService)
    {
        try {
            $salaryDeductionTypeSettingsService->deleteSalaryDeductionTypeSettings($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }

    public function statusUpdate(SalaryDeductionTypeSettingsService $salaryDeductionTypeSettingsService, $id, $status)
    {
        try {
            $salaryDeductionTypeSettingsService->statusUpdate($id, $status);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Status Update Success");
    }


}
