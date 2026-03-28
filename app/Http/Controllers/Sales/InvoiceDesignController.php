<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Sales\InvoiceDesignService;
use Illuminate\Http\Request;

class InvoiceDesignController extends BackendController
{
    private InvoiceDesignService $service;
    public function __construct()
    {
        $this->service = new InvoiceDesignService();
    }

    public function uploadDesign(Request $request)
    {
        try {
            $this->service->uploadDesign($request);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Design Uploaded Successfully');
    }
}
