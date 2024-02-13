<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Procurement\ProductMaterial\StoreMakePaymentRequest;
use App\Services\Procurement\ProductMaterial\PurchaseMakePaymentService;
use Illuminate\Http\Request;

class PurchaseMakePaymentController extends BackendController
{
    private PurchaseMakePaymentService $service;

    public function __construct(){
        $this->service = new PurchaseMakePaymentService();
    }

    public function makePayment($id)
    {
        try {
            $data = $this->service->makePaymentData($id);
            $view = view('procurement.product-material-purchase.make-payment._make_payment_data', $data)->render();

            return $this->returnAjaxSuccess(['view' => $view], 'Data Fetched Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }

    }

    public function makePaymentSubmit(StoreMakePaymentRequest $request, $id)
    {
        try {
            $this->service->makePaymentSubmit($request, $id);
            return $this->returnAjaxSuccess([], 'Payment Made Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
