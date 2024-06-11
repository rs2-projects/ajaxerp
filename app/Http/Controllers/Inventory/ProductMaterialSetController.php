<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ProductMaterialSet\StoreProductMaterialSetRequest;
use App\Http\Requests\Inventory\ProductMaterialSet\UpdateProductMaterialSetRequest;
use App\Services\Inventory\ProductMaterialSetService;
use Illuminate\Http\Request;

class ProductMaterialSetController extends BackendController
{
    private ProductMaterialSetService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material Set');

        $this->service = new ProductMaterialSetService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Set");
        $this->setActiveMenu('inventory.product-material-set.index');
        return  $this->view('inventory.product-material-set.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.product-material-set._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function create()
    {
        $this->setPageTitle("Create Product Material Set");
        $this->setActiveMenu('inventory.product-material-set.index');
        return  $this->view('inventory.product-material-set.create');
    }

    public function getAllProductMaterials(Request $request)
    {
        $data = $this->service->getAllProductMaterials($request);

        return response()->json($data);
    }

    public function store(StoreProductMaterialSetRequest $request)
    {
        try {
            $this->service->storeData($request);
            return $this->returnAjaxSuccess([], 'Data Save Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $this->setPageTitle("Edit Product Material Set");
            $this->setActiveMenu('inventory.product-material-set.index');
            $data = $this->service->editData($id);
             return $this->view('inventory.product-material-set.edit')
                ->with($data);
        }catch (\Exception $e) {
            return redirect()->route('inventory.product-material-set.index')->with('error', $e->getMessage());
        }
    }

    public function getSetItems($id){
        try {
            $data = $this->service->getSetItemsData($id);
            return response()->json($data);
        }catch (\Exception $e) {
            return redirect()->route('inventory.product-material-set.index')->with('error', $e->getMessage());
        }
    }

    public function update(UpdateProductMaterialSetRequest $request, $id){
        try {
            $this->service->updateData($request, $id);
            return $this->returnAjaxSuccess([], 'Data Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function delete($id)
    {
        try {
            $this->service->deleteData($id);
            return $this->returnAjaxSuccess([], 'Data Delete Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function details($id)
    {
        try {
            $this->setPageTitle("Product Material Set Details");
            $this->setActiveMenu('inventory.product-material-set.index');
            $data = $this->service->detailsData($id);
             return $this->view('inventory.product-material-set.details')
                ->with($data);
        }catch (\Exception $e) {
            return redirect()->route('inventory.product-material-set.index')->with('error', $e->getMessage());
        }
    }

}
