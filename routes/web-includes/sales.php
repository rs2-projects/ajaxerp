<?php

use App\Http\Controllers\Sales\CustomerController;
use App\Http\Controllers\Sales\InvoiceController;
use App\Http\Controllers\Sales\InvoiceDeliveredController;
use App\Http\Controllers\Sales\InvoiceDesignController;
use App\Http\Controllers\Sales\QuotationController;
use Illuminate\Support\Facades\Route;
//customer routes start
Route::prefix('customers')->group(function(){
    Route::get('/', [CustomerController::class, 'index'])->name('sales.customer.index')->middleware('permission:view-customers');
    Route::post('/filtered', [CustomerController::class, 'indexFiltered'])->name('sales.customer.filtered')->middleware('permission:view-customers');
    Route::get('/create', [CustomerController::class, 'create'])->name('sales.customer.create')->middleware('permission:manage-customers');
    Route::post('/create', [CustomerController::class, 'store'])->name('sales.customer.store')->middleware('permission:manage-customers');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('sales.customer.edit')->middleware('permission:manage-customers');
    Route::post('/{id}/update', [CustomerController::class, 'update'])->name('sales.customer.update')->middleware('permission:manage-customers');
    Route::get('/{id}/delete', [CustomerController::class, 'delete'])->name('sales.customer.delete')->middleware('permission:manage-customers');
    Route::get('/get-states-by-country', [CustomerController::class, 'getStatesByCountry'])->name('sales.customer.get-states-by-country')->middleware('permission:manage-customers');
});
//customer routes end

//start invoice route
Route::prefix('invoice')->group(function(){
    Route::get('/',[InvoiceController::class,'index'])->name('sales.invoice.index')->middleware('permission:view-invoices');
    //Filter invoice data
    Route::post('/filtered',[InvoiceController::class,'indexFilteredData'])->name('sales.invoice.filtered')->middleware('permission:view-invoices');
    Route::get('/get-all-customer',[InvoiceController::class,'getAllCustomer'])->name('sales.invoice.get-all-customer')->middleware('permission:manage-invoices');
    Route::get('/get-all-finished-goods',[InvoiceController::class,'getAllFinishedGoods'])->name('sales.invoice.get-all-finished-goods')->middleware('permission:manage-invoices');
    Route::get('/get-all-taxes',[InvoiceController::class,'getAllTaxes'])->name('sales.invoice.get-all-taxes')->middleware('permission:manage-invoices');
    Route::get('/get-design/{id}',[InvoiceController::class,'getDesign'])->name('sales.invoice.design')->middleware('permission:view-invoices');
    //create invoice data
    Route::get('/create',[InvoiceController::class,'create'])->name('sales.invoice.create')->middleware('permission:manage-invoices');
    Route::post('/create',[InvoiceController::class,'store'])->name('sales.invoice.store')->middleware('permission:manage-invoices');
    // make payment
    Route::get('/{id}/make-payment', [InvoiceController::class, 'makePayment'])->name('sales.invoice.make-payment')->middleware('permission:make-payment');
    Route::post('/{id}/make-payment-submit', [InvoiceController::class, 'makePaymentSubmit'])->name('sales.invoice.make-payment-submit')->middleware('permission:make-payment');
    //Edit invoice data
    Route::get('/{id}/edit',[InvoiceController::class,'edit'])->name('sales.invoice.edit')->middleware('permission:manage-invoices');
    Route::get('/{id}/get-edit-invoice-data',[InvoiceController::class,'getEditInvoiceData'])->name('sales.invoice.get-edit-invoice-data')->middleware('permission:manage-invoices');
    //update invoice data
    Route::post('/{id}/update',[InvoiceController::class,'update'])->name('sales.invoice.update')->middleware('permission:manage-invoices');
    //Delete invoice
    
    Route::get('/{id}/delete',[InvoiceController::class,'delete'])->name('sales.invoice.delete')->middleware('permission:manage-invoices');
    //Upload invoice design
    Route::post('/upload-design',[InvoiceDesignController::class,'uploadDesign'])->name('sales.invoice.design_upload')->middleware('permission:manage-invoices');
    //Design delete
    Route::get('/{id}/delete-design',[InvoiceController::class,'deleteDesign'])->name('sales.invoice.design.delete')->middleware('permission:manage-invoices');

    Route::get('/{id}/production-status',[InvoiceController::class,'getProductionStatus'])->name('sales.invoice.production-status')->middleware('permission:view-invoices');

    Route::get('{id}/download-pdf',[InvoiceController::class,'downloadPdf'])->name('sales.invoice.download-pdf')->middleware('permission:view-invoices');
    Route::get('{id}/download-delivery-receipt-pdf',[InvoiceController::class,'downloadDeliveryReceiptPdf'])->name('sales.invoice.download-delivery-receipt-pdf')->middleware('permission:view-invoices');
    Route::get('{id}/download-gatepass-pdf',[InvoiceController::class,'downloadGatepassPdf'])->name('sales.invoice.download-gatepass-pdf')->middleware('permission:view-invoices');

    
    //Invoice delivered (not in use)
    Route::get('/{id}/deliver', [InvoiceDeliveredController::class, 'deliver'])->name('sales.invoice.deliver')->middleware('permission:deliver-items');
    Route::post('/{id}/deliver', [InvoiceDeliveredController::class, 'deliverStore'])->name('sales.invoice.deliver.store')->middleware('permission:deliver-items');
    Route::get('/{id}/finished-goods', [InvoiceDeliveredController::class, 'getFinishedGoods'])->name('sales.invoice.deliver.get-all-finished-goods')->middleware('permission:deliver-items');
    Route::get('/{id}/deliver/{barcode}/{count}', [InvoiceDeliveredController::class, 'checkBarCode'])->name('sales.invoice.deliver.check-barcode')->middleware('permission:deliver-items');


});

//start quotation route
Route::prefix('quotation')->group(function(){
    Route::get('/',[QuotationController::class,'index'])->name('sales.quotation.index')->middleware('permission:view-invoices');
    Route::post('/filtered',[QuotationController::class,'indexFilteredData'])->name('sales.quotation.filtered')->middleware('permission:view-invoices');
    //create invoice data
    Route::get('/create',[QuotationController::class,'create'])->name('sales.quotation.create')->middleware('permission:manage-invoices');
    Route::post('/create',[QuotationController::class,'store'])->name('sales.quotation.store')->middleware('permission:manage-invoices');

    //Edit invoice data
    Route::get('/{id}/edit',[QuotationController::class,'edit'])->name('sales.quotation.edit')->middleware('permission:manage-invoices');
    Route::get('/{id}/get-edit-quotation-data',[QuotationController::class,'getEditQuotationData'])->name('sales.quotation.get-edit-quotation-data')->middleware('permission:manage-invoices');
    //update invoice data
    Route::post('/{id}/update',[QuotationController::class,'update'])->name('sales.quotation.update')->middleware('permission:manage-invoices');
    //Delete invoice
    Route::get('/{id}/delete',[QuotationController::class,'delete'])->name('sales.quotation.delete')->middleware('permission:manage-invoices');

    Route::get('{id}/convert-to-invoice',[QuotationController::class,'convertToInvoice'])->name('sales.quotation.convert-to-invoice')->middleware('permission:manage-invoices');
    Route::get('{id}/get-convert-to-invoice-data',[QuotationController::class,'getConvertToInvoiceData'])->name('sales.quotation.get-convert-to-invoice-data')->middleware('permission:manage-invoices');
    Route::post('{id}/convert-to-invoice',[QuotationController::class,'convertToInvoiceStore'])->name('sales.quotation.convert-to-invoice-store')->middleware('permission:manage-invoices');

    Route::get('{id}/download-pdf',[QuotationController::class,'downloadPdf'])->name('sales.quotation.download-pdf')->middleware('permission:view-invoices');

    // all pending quotations
    Route::get('/pending-quotations', [QuotationController::class, 'pendingQuotations'])->name('sales.quotation.pending-quotations')->middleware('permission:view-invoices');
});
