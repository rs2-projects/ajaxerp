<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Sales\StoreInvoiceDeliverRequest;
use App\Services\Inventory\DispatchInvoiceService;
use Illuminate\Http\Request;

class DispatchInvoiceController extends BackendController
{
    private DispatchInvoiceService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('sales.invoice.index'), 'fa fa-home');
        $this->addBreadcrumbs('Dispatch Items');
        $this->service = new DispatchInvoiceService();
    }

    public function index()
    {
        $this->setPageTitle("Dispatch Items");
        $this->setActiveMenu('inventory.dispatch-invoice.index');
        $data = $this->service->indexData();
        return  $this->view('inventory.sales-dispatch.index')->with($data);

    }
    //IndexFiltered Data
    public function indexFilteredData(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function deliver($id)
    {
        $this->setPageTitle("Dispatch Items");
        $this->setActiveMenu('inventory.dispatch-invoice.index');
        $data = $this->service->deliverData($id);
        return $this->view('inventory.sales-dispatch.deliver')->with($data);
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