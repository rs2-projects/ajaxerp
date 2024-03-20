<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\StoreInvoicePaymentRequest;
use App\Services\Sales\InvoicePaymentService;
use Illuminate\Http\Request;

class InvoicePaymentController extends Controller
{
    private InvoicePaymentService $service;
    public function __construct()
    {
        $this->service = new InvoicePaymentService();
    }

    //store invoice payment
    public function store(StoreInvoicePaymentRequest $request)
    {
        try {
            $this->service->store($request);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Invoice Payment Created Successfully');
    }
}
