<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Sales\StoreInvoiceDeliverRequest;
use App\Services\Sales\InvoiceDeliverService;

class InvoiceDeliveredController extends BackendController
{
    private InvoiceDeliverService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Invoices', route('sales.invoice.index'), 'fa fa-home');
        $this->addBreadcrumbs('Invoice Delivered');

        $this->service = new InvoiceDeliverService();
    }

    public function deliver($id)
    {
        $this->setPageTitle("Deliver Invoice");
        $this->setActiveMenu('sales.invoice.deliver');
        $data = $this->service->deliverData($id);
        return $this->view('sales.invoice.deliver')->with($data);
    }
    public function getFinishedGoods($id){
        $data = $this->service->getFinishedGoodsData($id);
        return $this->returnAjaxSuccess($data);
    }

    public function checkBarCode($finished_good_id, $barcode, $count)
    {
        $data = $this->service->checkBarCode($finished_good_id, $barcode, $count);
        return $data;
    }

    public function deliverStore(StoreInvoiceDeliverRequest $request, $id){
        try {
             $this->service->deliverStoreData($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Delivered successfully');
    }
}
