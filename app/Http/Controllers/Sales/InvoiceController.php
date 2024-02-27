<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
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
}
