<?php

namespace App\Http\Controllers\Procurement\Assets;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\Assets\PurchaseOrder\StorePaymentRequest;
use App\Services\Procurement\Assets\PurchaseOrder\PurchaseOrderPaymentService;
use Illuminate\Http\Request;

class PuchaseOrderPaymentController extends BackendController
{
    private PurchaseOrderPaymentService $service;

    public function __construct(){
        $this->service = new PurchaseOrderPaymentService();
    }

    public function makePayment($id)
    {
        try {
            $data = $this->service->makePaymentData($id);
            $view = view('procurement.asset-purchase-order._make_payment_modal', $data)->render();

            return $this->returnAjaxSuccess(['view' => $view], 'Data Fetched Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }

    }

    public function makePaymentSubmit(StorePaymentRequest $request, $id)
    {
        try {
            $this->service->makePaymentSubmit($request, $id);
            return $this->returnAjaxSuccess([], 'Payment Made Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
