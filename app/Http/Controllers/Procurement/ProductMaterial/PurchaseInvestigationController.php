<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Procurement\ProductMaterial\PurchaseInvestigationService;
use Illuminate\Http\Request;

class PurchaseInvestigationController extends BackendController
{
    private PurchaseInvestigationService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Material Purchase Investigation');

        $this->service = new PurchaseInvestigationService();
    }

    public function index($purchase_id)
    {
        try {
            $this->setPageTitle("Material Purchase Investigation");
            $this->setActiveMenu('procurement.product-material-purchase.index');

            $data = $this->service->indexData($purchase_id);


        }catch (\Exception $e) {
            return redirect()->route('procurement.product-material-purchase.index')->with('error', $e->getMessage());
        }

        return $this->view('procurement.product-material-purchase.purchase-investigation.index')->with($data);

    }

    public function update(Request $request, $purchase_id)
    {
        try {
            $this->service->updateData($request, $purchase_id);

            return $this->returnAjaxSuccess([], 'Purchase Investigation Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
