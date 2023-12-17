<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\SalaryType\StoreSalaryTypeSettingsRequest;
use App\Http\Requests\Settings\SalaryType\UpdateSalaryTypeSettingsRequest;
use App\Services\Settings\SalaryTypeSettingsService;
use Illuminate\Http\Request;

class SalaryTypeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Salary Type');
    }

    public function index()
    {
        $this->setPageTitle("Salary Type");
        $this->setActiveMenu('settings.salary-type');

        return $this->view('settings.salary-type.index');
    }

    public function indexFiltered(Request $request, SalaryTypeSettingsService $salaryTypeSettingsService)
    {
        $data = $salaryTypeSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.salary-type._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create()
    {
        $this->setPageTitle("Create Salary Type");
        $this->setActiveMenu('settings.salary-type.create');

        return $this->view('settings.salary-type.create');
    }

    public function store(StoreSalaryTypeSettingsRequest $request, SalaryTypeSettingsService $salaryTypeSettingsService)
    {
        try {
            $salaryTypeSettingsService->store($request);

        }catch (\Exception $e) {
            return $this->returnAjaxException($e);
        }

        return $this->returnAjaxSuccess([], 'Salary Type created successfully.');
    }

    public function edit(SalaryTypeSettingsService $salaryTypeSettingsService, $id)
    {
        try {
            $this->setPageTitle("Edit Salary Type");
            $this->setActiveMenu('settings.salary-type.edit', $id);
            $data = $salaryTypeSettingsService->getEditData($id);

            return  $this->view('settings.salary-type.edit')->with($data);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

    }

    public function update(UpdateSalaryTypeSettingsRequest $request, SalaryTypeSettingsService $salaryTypeSettingsService, $id)
    {
        try {
            $salaryTypeSettingsService->update($request, $id);

        }catch (\Exception $e) {
            return $this->returnAjaxException($e);
        }

        return $this->returnAjaxSuccess([], 'Salary Type updated successfully.');
    }

    public function delete(SalaryTypeSettingsService $salaryTypeSettingsService, $id)
    {
        try {
            $salaryTypeSettingsService->delete($id);

        }catch (\Exception $e) {
            return $this->returnAjaxException($e);
        }

        return $this->returnAjaxSuccess([], 'Salary Type deleted successfully.');
    }

    public function statusUpdate(SalaryTypeSettingsService $salaryTypeSettingsService, $id, $status)
    {
        try {
            $salaryTypeSettingsService->statusUpdate($id, $status);

        }catch (\Exception $e) {
            return $this->returnAjaxException($e);
        }

        return $this->returnAjaxSuccess([], 'Salary Type status updated successfully.');
    }
}
