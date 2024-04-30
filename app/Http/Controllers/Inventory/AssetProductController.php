<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\AssetProduct\StoreAssetPorductAssignRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Inventory\AssetProduct\StoreAssetProductRequest;
use App\Http\Requests\Inventory\AssetProduct\UpdateAssetProductRequest;
use App\Services\Inventory\AssetProductService;

class AssetProductController extends BackendController
{
    private AssetProductService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Asset Product');

        $this->service = new AssetProductService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Products");
        $this->setActiveMenu('inventory.asset-product.index');
        $data = $this->service->indexData();

        return  $this->view('inventory.assets.asset-product.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        // $data = $this->service->indexFilteredData($request);
        // $view = $this->view('inventory.assets.asset-product._index_filtered')
        //     ->with($data)
        //     ->render();

        // return $this->returnAjaxSuccess(['view' => $view]);

        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function store(StoreAssetProductRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product created successfully');
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

    public function update(UpdateAssetProductRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product updated successfully');
    }

    public function assignedDetails($id)
    {
        try {
            $data = $this->service->detailsData($id);
            $view = $this->view('inventory.assets.asset-product._assign_details_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product deleted successfully');
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

    public function assignProduct(StoreAssetPorductAssignRequest $request, $id){
        try {
            $this->service->assignProductStore($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Assigned Successfully');
    }

    public function maintenanceProduct(StoreAssetPorductAssignRequest $request, $id){
        try {
            $this->service->maintenanceProductStore($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Maintenance Success');
    }

    public function sellProduct(StoreAssetPorductAssignRequest $request, $id){
        try {
            $this->service->sellProductStore($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Sold Successfully');
    }

    public function disposeProduct(StoreAssetPorductAssignRequest $request, $id){
        try {
            $this->service->disposeProductStore($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Disposed Successfully');
    }

    public function returnProduct(StoreAssetPorductAssignRequest $request, $id){
        try {
            $this->service->returnProductStore($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Returned Successfully');
    }
}
