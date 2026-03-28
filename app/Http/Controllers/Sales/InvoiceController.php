<?php

namespace App\Http\Controllers\Sales;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Procurement\ProductMaterial\StoreMakePaymentRequest;
use App\Http\Requests\Sales\StoreInvoiceRequest;
use App\Http\Requests\Sales\UpdateInvoiceRequest;
use App\Services\Sales\Invoice\InvoiceService;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

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
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }
    //getDesign
    public function getDesign($id)
    {
        try {
            $data = $this->service->getDesign($id);
            return$this->returnAjaxSuccess([
                'view' => $data['view'],
                'upload_view' => $data['upload_view'] ?? '',
            ], 'Data Fetch Successfully');
        } catch (\Exception $e) {
            return $this->returnAjaxError([], $e->getMessage());
        }
    }

    //Create Invoice
    public function create()
    {
        $this->setPageTitle("New Invoice");
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
    // public function getAllFinishedGoods(Request $request)
    // {
    //     $data = $this->service->getAllFinishedGoods($request);
    //     return response()->json($data['finished_goods']);
    // }

    public function getAllFinishedGoods()
    {
        $data = $this->service->getAllFinishedGoods();
        return response()->json($data);
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
    //make payment data
    public function makePayment($id)
    {
        try {
            $data = $this->service->makePaymentData($id);
            $view = view('sales.invoice.make-payment._make_payment_data', $data)->render();

            return $this->returnAjaxSuccess(['view' => $view], 'Data Fetched Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }

    }
    // make payment submit
    public function makePaymentSubmit(StoreMakePaymentRequest $request, $id)
    {
        try {
            $this->service->makePaymentSubmit($request, $id);
            return $this->returnAjaxSuccess([], 'Payment Made Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    //edit invoice
    public function edit($id){
        $this->setPageTitle("Edit Invoice");
        $this->setActiveMenu('sales.invoice.index');

        $data = $this->service->editData($id);

        if (!isset($data['invoice'])) {
            return redirect()->route('sales.invoice.index')->with(['failed' => 'Invalid Invoice!']);
        }

        $invoice = $data['invoice'];

        if($invoice->payment_status != $invoice::PAYMENT_STATUS_UNPAID){
            return redirect()->route('sales.invoice.index')->with(['failed' => 'You can not edit this invoice!']);
        }

        return $this->view('sales.invoice.edit')->with($data);
    }
    //Get edit invoice data
    public function getEditInvoiceData($id)
    {
        $data = $this->service->getEditInvoiceData($id);
        return response()->json($data);
    }
    //update invoice
    public function update(UpdateInvoiceRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);

            return $this->returnAjaxSuccess([], 'Invoice Updated Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    //delete invoce design
    public function deleteDesign($id)
    {
        try {
            $this->service->deleteDesign($id);
            return $this->returnAjaxSuccess([], 'Invoice design Deleted Successfully');
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

    public function getProductionStatus($id)
    {
        $data = $this->service->getProductionStatus($id);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetched Successfully');
    }

    public function downloadPdf($id)
    {
        // try {
            $data = $this->service->getDownloadPdfData($id);

            // return view('sales.invoice.pdf', $data);
            $pdf = PDF::loadView('sales.invoice.pdf', $data);
            $pdf->setPaper('a4');
            $pdf->setOrientation('portrait');
            $pdf->setOption('margin-bottom', 15);
            $pdf->setOption('margin-top', 15);
            if($data['invoice']->invoice_footer != "") {
                $pdf->setOption('footer-center', $data['invoice']->invoice_footer);
            }
            return $pdf->inline('Invoice-'.$data['invoice']->invoice_no.'.pdf');

        // }catch (\Exception $e) {
        //     dd($e->getMessage());
        //     return redirect()->back()->with(['failed' => $e->getMessage()]);
        // }
    }

    public function downloadDeliveryReceiptPdf($id)
    {
        $data = $this->service->getDownloadPdfData($id);

        $pdf = PDF::loadView('sales.invoice.delivery-receipt-pdf', $data);
        $pdf->setPaper('a4');
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-bottom', 15);
        $pdf->setOption('margin-top', 15);
        if($data['invoice']->invoice_footer != "") {
            $pdf->setOption('footer-center', $data['invoice']->invoice_footer);
        }

        return $pdf->inline('Delivery-Receipt-'.$data['invoice']->invoice_no.'.pdf');
    }

    public function downloadGatepassPdf($id)
    {
        $data = $this->service->getDownloadPdfData($id);

        $pdf = PDF::loadView('sales.invoice.gatepass-pdf', $data);
        $pdf->setPaper('a4');
        $pdf->setOrientation('portrait');
        $pdf->setOption('margin-bottom', 15);
        $pdf->setOption('margin-top', 15);
        if($data['invoice']->invoice_footer != "") {
            $pdf->setOption('footer-center', $data['invoice']->invoice_footer);
        }

        return $pdf->inline('Gatepass-'.$data['invoice']->invoice_no.'.pdf');
    }
}
