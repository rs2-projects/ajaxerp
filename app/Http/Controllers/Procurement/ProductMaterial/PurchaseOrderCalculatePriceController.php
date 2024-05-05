<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Procurement\ProductMaterial\StorePurchaseCalculatePriceRequest;
use App\Services\Procurement\ProductMaterial\PurchaseCalculatePriceService;
use Illuminate\Http\Request;

class PurchaseOrderCalculatePriceController extends BackendController
{
    private PurchaseCalculatePriceService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Calculate Price');

        $this->service = new PurchaseCalculatePriceService();
    }

    // other prodcts start
    public function index($purchase_id)
    {
        try {
            $this->setPageTitle("Calculate Others Price");
            $this->setActiveMenu('procurement.product-material-purchase.index');
            $data = $this->service->indexData($purchase_id);
        } catch (\Exception $e) {
            return redirect()->route('procurement.product-material-purchase.index')->with('error', $e->getMessage());
        }

        return $this->view('procurement.product-material-purchase.calculate-price.index')->with($data);
    }

    public function store(StorePurchaseCalculatePriceRequest $request, $purchase_id)
    {
        try {
            $this->service->storeData($request, $purchase_id);

            return $this->returnAjaxSuccess([], 'Calculated Price Updated Successfully');
        } catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    // Others product end

    // board product start
    public function showBoardCalculateForm($purchase_id)
    {
        try {
            $this->setPageTitle("Calculate Board Price");
            $this->setActiveMenu('procurement.product-material-purchase.index');
            $data = $this->service->boardCalculateFormData($purchase_id);
        } catch (\Exception $e) {
            return redirect()->route('procurement.product-material-purchase.index')->with('error', $e->getMessage());
        }

        return $this->view('procurement.product-material-purchase.calculate-price.board_products')->with($data);
    }

    public function storeBoardCalculateForm(StorePurchaseCalculatePriceRequest $request, $purchase_id)
    {
        try {
            $this->service->storeBoardCalculateForm($request, $purchase_id);

            return $this->returnAjaxSuccess([], 'Calculated Price Updated Successfully');
        } catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
