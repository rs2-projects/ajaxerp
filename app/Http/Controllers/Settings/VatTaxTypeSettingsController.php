<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\VatTaxType\StoreVatTaxTypeRequest;
use App\Http\Requests\Settings\VatTaxType\UpdateVatTaxTypeRequest;
use App\Services\Settings\VatTaxTypeSettingsService;
use Illuminate\Http\Request;

class VatTaxTypeSettingsController extends BackendController
{
    private VatTaxTypeSettingsService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Vat Tax Type');

        $this->service = new VatTaxTypeSettingsService();
    }

    public function index()
    {
        $this->setPageTitle("Vat Tax Type");
        $this->setActiveMenu('settings.vat-tax-type.index');

        return  $this->view('settings.vat-tax-type.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('settings.vat-tax-type._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreVatTaxTypeRequest $request)
    {
        try {
            $this->service->storeData($request);
        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Vat Tax Type has been created successfully');
    }

    public function edit($id)
    {
        try {

            $data = $this->service->editData($id);

            $view = $this->view('settings.vat-tax-type._edit_data')
                ->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);

        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }

    }

    public function update(UpdateVatTaxTypeRequest $request, $id)
    {
        try {
            $this->service->updateData($request, $id);
        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Vat Tax Type has been updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->deleteDate($id);
        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Vat Tax Type has been deleted successfully');
    }
}
