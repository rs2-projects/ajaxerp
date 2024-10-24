<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Sales\StoreQuotationRequest;
use App\Services\Sales\Quotation\QuotationService;
use Illuminate\Http\Request;

class QuotationController extends BackendController
{
    private QuotationService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Sales', route('sales.quotation.index'), 'fa fa-home');
        $this->addBreadcrumbs('Quotation list');
        $this->service = new QuotationService();
    }
    //index
    public function index()
    {
        $this->setPageTitle("Quotations");
        $this->setActiveMenu('sales.quotation.index');
        $data = $this->service->indexData();
        return  $this->view('sales.quotation.index')->with($data);

    }

    //IndexFiltered Data
    public function indexFilteredData(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    //Create Invoice
    public function create()
    {
        $this->setPageTitle("New Quotation");
        $this->setActiveMenu('sales.quotation.index');
        $data = $this->service->createData();
        return $this->view('sales.quotation.create')->with($data);
    }

    public function store(StoreQuotationRequest $request)
    {
        try {
            $this->service->store($request);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Quotation Created Successfully');
    }
}
