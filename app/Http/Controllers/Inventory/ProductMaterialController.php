<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\ProductMaterial\StoreProductMaterialRequest;
use App\Http\Requests\Inventory\ProductMaterial\UpdateProductMaterialRequest;
use App\Services\Inventory\ProductMaterialService;
use Illuminate\Http\Request;

class ProductMaterialController extends BackendController
{
    private ProductMaterialService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material');

        $this->service = new ProductMaterialService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material");
        $this->setActiveMenu('inventory.product-material.index');
        $data = $this->service->indexData();
        return  $this->view('inventory.product-material.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.product-material._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function store(StoreProductMaterialRequest $request)
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
            $this->setPageTitle("Edit Product Material");
            $this->setActiveMenu('inventory.product-material.index');

            $data = $this->service->editData($id);
             return $this->view('inventory.product-material.edit')
                ->with($data);
        }catch (\Exception $e) {
            return redirect()->route('inventory.product-material.index')->with('error', $e->getMessage());
        }
    }

    public function update(UpdateProductMaterialRequest $request, $id)
    {
        try {
            $this->service->updateData($request, $id);
            return $this->returnAjaxSuccess([], 'Data Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function purchaseHistory($id)
    {
        try {
            $data = $this->service->purchaseHistory($id);
            $view = $this->view('inventory.product-material._purchase_history_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess(['view' => $view]);
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

    public function statusUpdate($id, $status)
    {
        try {
            $this->service->statusUpdateData($id, $status);
            return $this->returnAjaxSuccess([], 'Status Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function getSectionsByWarehouse(Request $request)
    {
        $data = $this->service->getSectionsByWarehouseData($request);
        $view = $this->view('inventory.product-material.__section_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function getRacksBySections(Request $request)
    {
        $data = $this->service->getRacksBySectionsData($request);
        $view = $this->view('inventory.product-material.__rack_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function importBoards(Request $request)
    {
        try {
            $this->service->importProducts($request, 'boards');
            return redirect()->back()->with(['success' => 'Boards Imported Successfully!']);
//            return $this->returnAjaxSuccess([], 'Boards Imported Successfully!');
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => $e->getMessage()]);
//            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function importPapers(Request $request)
    {
        try {
            $this->service->importProducts($request, 'papers');
            return redirect()->back()->with(['success' => 'Papers Imported Successfully!']);
//            return $this->returnAjaxSuccess([], 'Papers Imported Successfully');
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => $e->getMessage()]);
//            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
