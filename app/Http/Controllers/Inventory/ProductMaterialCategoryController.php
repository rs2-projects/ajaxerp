<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ProductMaterialCategory\StoreCategoryReqeust;
use App\Http\Requests\Inventory\ProductMaterialCategory\UpdateCategoryReqeust;
use App\Services\Inventory\ProductMaterialCategoryService;
use Illuminate\Http\Request;

class ProductMaterialCategoryController extends BackendController
{
    private ProductMaterialCategoryService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material Category');

        $this->service = new ProductMaterialCategoryService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Category");
        $this->setActiveMenu('inventory.product-material-category.index');

        return  $this->view('inventory.product-material-category.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.product-material-category._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreCategoryReqeust $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Product Material Category created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('inventory.product-material-category._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateCategoryReqeust $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Product Material Category updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Product Material Category deleted successfully');
    }
}
