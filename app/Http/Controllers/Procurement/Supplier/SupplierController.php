<?php

namespace App\Http\Controllers\Procurement\Supplier;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Procurement\Supplier\StoreSupplierRequest;
use App\Http\Requests\Procurement\Supplier\UpdateSupplierRequest;
use App\Services\Procurement\Supplier\SupplierService;

class SupplierController extends BackendController
{
    private SupplierService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Supplier');

        $this->service = new SupplierService();
    }

    public function index()
    {
        $this->setPageTitle("Suupliers");
        $this->setActiveMenu('procurement.supplier.index');

        return  $this->view('procurement.supplier.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('procurement.supplier._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreSupplierRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Supplier created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('inventory.assets.asset-product._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateSupplierRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Supplier updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Supplier deleted successfully');
    }
}
