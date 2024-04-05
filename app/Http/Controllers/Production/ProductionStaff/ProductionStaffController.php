<?php

namespace App\Http\Controllers\Production\ProductionStaff;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\ProductionStaff\StoreProductionStaffRequest;
use App\Http\Requests\Production\ProductionStaff\UpdateProductionStaffRequest;
use App\Services\Production\ProductionStaff\ProductionStaffService;
use Illuminate\Http\Request;

class ProductionStaffController extends BackendController
{
    private ProductionStaffService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Production Staff');

        $this->service = new ProductionStaffService();
    }

    public function index()
    {
        $this->setPageTitle("Production Staff");
        $this->setActiveMenu('production.production-staff.index');
        $data = $this->service->indexData();

        return  $this->view('production.production-staff.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('production.production-staff._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreProductionStaffRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Production staff created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('production.production-staff._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateProductionStaffRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Production Staff updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Production staff deleted successfully');
    }

    public function statusUpdate($id, $status)
    {
        try {
            $this->service->statusUpdateData($id, $status);
            return $this->returnAjaxSuccess([], 'Status Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
