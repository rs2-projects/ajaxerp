<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Inventory\AssetProductCategory\StoreAssetCategoryRequest;
use App\Http\Requests\Inventory\AssetProductCategory\UpdateAssetCategoryRequest;
use App\Services\Inventory\AssetProductCategoryService;

class AssetProductCategoryController extends BackendController
{
    private AssetProductCategoryService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Asset Product Category');

        $this->service = new AssetProductCategoryService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Product Category");
        $this->setActiveMenu('inventory.assets.asset-product-category.index');

        return  $this->view('inventory.assets.asset-product-category.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.assets.asset-product-category._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreAssetCategoryRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Category created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('inventory.assets.asset-product-category._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateAssetCategoryRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Category updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Asset Product Category deleted successfully');
    }
}
