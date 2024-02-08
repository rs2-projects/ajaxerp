<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\ProductMaterial\StorePurchaseReqeust;
use App\Http\Requests\Procurement\ProductMaterial\UpdatePurchaseReqeust;
use App\Services\Procurement\ProductMaterial\ProductMaterialPurchaseService;
use Illuminate\Http\Request;

class ProductMaterialPurchaseController extends BackendController
{
    private ProductMaterialPurchaseService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material Purchase');

        $this->service = new ProductMaterialPurchaseService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Purchase");
        $this->setActiveMenu('procurement.product-material-purchase.index');
        $data = $this->service->indexData();
        return  $this->view('procurement.product-material-purchase.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);

        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function create()
    {
        $this->setPageTitle("New Purchase Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');
        $data = $this->service->createData();
        return $this->view('procurement.product-material-purchase.create')->with($data);
    }

    public function store(StorePurchaseReqeust $reqeust)
    {
        /*dd($reqeust->all());*/
        try {
            $this->service->store($reqeust);

            return $this->returnAjaxSuccess([], 'Purchase Order Created Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function edit($id)
    {
        $this->setPageTitle("Edit Purchase Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        $data = $this->service->editData($id);

        return $this->view('procurement.product-material-purchase.edit')->with($data);
    }

    public function getEditPurchaseData(Request $request, $id)
    {
        $data = $this->service->getEditPurchaseData($request, $id);

        return response()->json($data);
    }

    public function update(UpdatePurchaseReqeust $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return $this->returnAjaxSuccess([], 'Purchase Order Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function statusUpdate($id, $status)
    {
        try {
            $this->service->statusUpdate($id, $status);

            return $this->returnAjaxSuccess([], 'Status Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function getAllProductMaterials(Request $request)
    {
        $data = $this->service->getAllProductMaterials($request);

        return response()->json($data);
    }

    public function getAllTaxes(Request $request)
    {
        $data = $this->service->getAllTaxes($request);

        return response()->json($data['vat_taxes']);
    }

    public function getAllSuppliers(Request $request)
    {
        $data = $this->service->getAllSuppliers($request);

        return response()->json($data['suppliers']);
    }
}
