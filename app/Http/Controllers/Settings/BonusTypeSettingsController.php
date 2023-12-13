<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Settings\BonusType\StoreBonusTypeSettingsRequest;
use App\Http\Requests\Settings\BonusType\UpdateBonusTypeSettingsRequest;
use App\Services\Settings\BonusTypeSettingsService;
use Illuminate\Http\Request;

class BonusTypeSettingsController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Bonus Type');
    }

    public function index()
    {
        $this->setPageTitle("Bonus Type");
        $this->setActiveMenu('settings.bonus-type');

        return $this->view('settings.bonus-type.index');
    }

    public function indexFiltered(Request $request, BonusTypeSettingsService $bonusTypeSettingsService)
    {
        $data = $bonusTypeSettingsService->getIndexFilteredData($request);
        $view = $this->view('settings.bonus-type._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreBonusTypeSettingsRequest $request, BonusTypeSettingsService $bonusTypeSettingsService)
    {

        try {
            $bonusTypeSettingsService->storeBonusTypeSettings($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(BonusTypeSettingsService $bonusTypeSettingsService, $id)
    {
        $data = $bonusTypeSettingsService->getEditData($id);

        $view = $this->view('settings.bonus-type._edit_data')->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateBonusTypeSettingsRequest $request, BonusTypeSettingsService $bonusTypeSettingsService, $id)
    {
        try {
            $bonusTypeSettingsService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([],"Update Success");
    }

    public function delete(BonusTypeSettingsService $bonusTypeSettingsService, $id)
    {
        try {

            $bonusTypeSettingsService->delete($id);

        } catch (\Exception $exception) {

            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([],"Delete Success");
    }

    public function statusUpdate(BonusTypeSettingsService $bonusTypeSettingsService, $id, $status)
    {
        try {

            $bonusTypeSettingsService->statusUpdate($id, $status);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess([],"Status Update Success");
    }
}
