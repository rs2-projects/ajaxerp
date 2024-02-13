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

    public function create()
    {
        $this->setPageTitle("New Purchase Order(Assets)");
        $this->setActiveMenu('procurement.asset-purchase-order.index');
        $data = $this->service->createData();
        return $this->view('procurement.asset-purchase-order.create')->with($data);
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
