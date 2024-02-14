<?php

namespace App\Http\Controllers\Procurement\Assets;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\Assets\PurchaseOrder\StorePurchaseOrderRequest;
use App\Services\Procurement\Assets\PurchaseOrder\PurchaseOrderService;
use Illuminate\Http\Request;

class PurchaseOrderController extends BackendController
{
    private PurchaseOrderService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Asset Purchase Order');

        $this->service = new PurchaseOrderService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Purchase Order");
        $this->setActiveMenu('procurement.asset-purchase-order.index');
        return  $this->view('procurement.asset-purchase-order.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function create(Request $request)
    {
        $this->setPageTitle("New Purchase Order(Assets)");
        $this->setActiveMenu('procurement.asset-purchase-order.index');
        $data = $this->service->createData();
        $data['request_id'] = $request->request_id;
        $data['details_id'] = $request->details_id;
        return $this->view('procurement.asset-purchase-order.create')->with($data);
    }

    public function getSelectedPurchaseData(Request $request)
    {
        $details_ids = $request->input('details_ids');
        $data = $this->service->getSelectedPurchaseData($details_ids);
        return response()->json($data);
    }

    public function store(StorePurchaseOrderRequest $reqeust)
    {
        try {
            $this->service->store($reqeust);

            return $this->returnAjaxSuccess([], 'Asset Purchase Order Created Successfully');
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

    public function getAllAssetProducts(Request $request)
    {
        $data = $this->service->getAllAssetProducts($request);

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
