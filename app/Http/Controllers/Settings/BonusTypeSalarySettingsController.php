<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\BonusTypeSalary\StoreBonusTypeSalarySettingsRequest;
use App\Http\Requests\Settings\BonusTypeSalary\UpdateBonusTypeSalarySettingsRequest;
use App\Services\Settings\BonusTypeSalarySettingsService;
use Illuminate\Http\Request;

class BonusTypeSalarySettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Salary Bonus');
    }

    public function index(BonusTypeSalarySettingsService $bonusTypeSalarySettingsService)
    {
        $this->setPageTitle("Salary Bonus");
        $this->setActiveMenu('settings.bonus-type-salary');

        $data = $bonusTypeSalarySettingsService->indexData();

        return $this->view('settings.bonus-type-salary.index')->with($data);
    }

    public function indexFiltered(Request $request, BonusTypeSalarySettingsService $bonusTypeSalarySettingsService)
    {
        $data = $bonusTypeSalarySettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.bonus-type-salary._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreBonusTypeSalarySettingsRequest $request, BonusTypeSalarySettingsService $bonusTypeSalarySettingsService)
    {
        try {
            $bonusTypeSalarySettingsService->storeBonusTypeSalarySettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(BonusTypeSalarySettingsService $bonusTypeSalarySettingsService, $id)
    {
        $data = $bonusTypeSalarySettingsService->editData($id);
        $view = $this->view('settings.bonus-type-salary._edit_data')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateBonusTypeSalarySettingsRequest $request, BonusTypeSalarySettingsService $bonusTypeSalarySettingsService, $id)
    {
        try {
            $bonusTypeSalarySettingsService->updateBonusTypeSalarySettings($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(BonusTypeSalarySettingsService $bonusTypeSalarySettingsService, $id)
    {
        try {
            $bonusTypeSalarySettingsService->destroyBonusTypeSalarySettings($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }

    public function statusUpdate(BonusTypeSalarySettingsService $bonusTypeSalarySettingsService, $id, $status)
    {
        try {
            $bonusTypeSalarySettingsService->statusUpdate($id, $status);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Status Update Success");
    }
}
