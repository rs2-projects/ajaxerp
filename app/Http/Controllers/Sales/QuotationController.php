<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Sales\StoreQuotationRequest;
use App\Http\Requests\Sales\UpdateQuotationRequest;
use App\Services\Sales\Quotation\QuotationService;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class QuotationController extends BackendController
{
    private QuotationService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Sales', route('sales.quotation.index'), 'fa fa-home');
        $this->addBreadcrumbs('Quotations', route('sales.quotation.index'));
        $this->service = new QuotationService();
    }
    //index
    public function index()
    {
        $this->setPageTitle("Quotations");
        $this->setActiveMenu('sales.quotation.index');
        $this->addBreadcrumbs('List');
        
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
        $this->addBreadcrumbs('Create');
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

    //edit invoice
    public function edit($id){
        $this->setPageTitle("Edit Quotation");
        $this->setActiveMenu('sales.quotation.index');
        $this->addBreadcrumbs('Edit');

        $data = $this->service->editData($id);
        if (!isset($data['quotation'])) {
            return redirect()->route('sales.quotation.index')->with(['failed' => 'Invalid Quotation!']);
        }

        if (!isset($data['quotation'])) {
            return redirect()->route('sales.quotation.index')->with(['failed' => 'Invalid Quotation!']);
        }

        $quotation = $data['quotation'];

        return $this->view('sales.quotation.edit')->with($data);
    }
    //Get edit invoice data
    public function getEditQuotationData($id)
    {
        $data = $this->service->getEditQuotationData($id);
        return response()->json($data);
    }
    //update invoice
    public function update(UpdateQuotationRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return $this->returnAjaxSuccess([], 'Quotation Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    // delete invoice
    public function delete($id)
    {
        try {
            $this->service->delete($id);
            return $this->returnAjaxSuccess([], 'Invoice Deleted Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function convertToInvoice($id)
    {
        try {
            $this->setPageTitle("Convert To Invoice");
            $this->setActiveMenu('sales.quotation.index');
            $this->addBreadcrumbs('Convert To Invoice');

            $data = $this->service->convertToInvoice($id);
            
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }

        return $this->view('sales.quotation.create-invoice')->with($data);
    }

    public function getConvertToInvoiceData($id) {
        $data = $this->service->getConvertToInvoiceData($id);
        return response()->json($data);
    }

    public function downloadPdf($id)
    {
        // try {
            $data = $this->service->getDownloadPdfData($id);

            // return view('sales.quotation.pdf', $data);
            $pdf = PDF::loadView('sales.quotation.pdf', $data);
            $pdf->setPaper('a4');
            $pdf->setOrientation('portrait');
            $pdf->setOption('margin-bottom', 15);
            $pdf->setOption('margin-top', 15);
            // $pdf->setOption('footer-center', "Powered By: Retinasoft | Hotline: +8801877756677 | http://www.retinasoft.com.bd");
            return $pdf->inline('Quotation-'.$data['quotation']->ref_no.'.pdf');

        // }catch (\Exception $e) {
        //     dd($e->getMessage());
        //     return redirect()->back()->with(['failed' => $e->getMessage()]);
        // }

    }
}
