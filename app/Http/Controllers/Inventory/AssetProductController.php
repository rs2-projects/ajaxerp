<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
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
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.assets.asset-product._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
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
}
