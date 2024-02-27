<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Sales\StoreInvoiceRequest;
use App\Services\Sales\Invoice\InvoiceService;
use Illuminate\Http\Request;

class InvoiceController extends BackendController
{
    private InvoiceService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Sales', route('sales.invoice.index'), 'fa fa-home');
        $this->addBreadcrumbs('Invoice list');
        $this->service = new InvoiceService();
    }
    //index
    public function index()
    {
        $this->setPageTitle("Invoice");
        $this->setActiveMenu('sales.invoice.index');
        $data = $this->service->indexData();
        return  $this->view('sales.invoice.index')->with($data);

    }
    //IndexFiltered Data
    public function indexFilteredData(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('sales.invoice._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    //Create Invoice
    public function create()
    {$this->setPageTitle("New Invoice");
        $this->setActiveMenu('sales.invoice.index');
        $data = $this->service->createData();
        return $this->view('sales.invoice.create')->with($data);
    }
    //Get all customers
    public function getAllCustomer(Request $request)
    {
        $data = $this->service->getAllCustomer($request);
        return response()->json($data['customers']);

    }
    //Get all finished goods
    public function getAllFinishedGoods(Request $request)
    {
        $data = $this->service->getAllFinishedGoods($request);
        return response()->json($data['finished_goods']);
    }
    //Get all taxes
    public function getAllTaxes(Request $request)
    {
        $data = $this->service->getAllTaxes($request);
        return response()->json($data['vat_taxes']);
    }
    //Invoice data store
    public function store(StoreInvoiceRequest $request)
    {
        try {
            $this->service->store($request);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Invoice Created Successfully');
    }
}
