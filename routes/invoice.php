<?php

use App\Http\Controllers\Sales\InvoiceController;
use App\Http\Controllers\Sales\InvoiceDeliveredController;
use App\Http\Controllers\Sales\InvoiceDesignController;
use Illuminate\Support\Facades\Route;

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
    //Invoice delivered
    Route::get('/{id}/deliver', [InvoiceDeliveredController::class, 'deliver'])->name('sales.invoice.deliver')->middleware('permission:deliver-items');
    Route::post('/{id}/deliver', [InvoiceDeliveredController::class, 'deliverStore'])->name('sales.invoice.deliver.store')->middleware('permission:deliver-items');
    Route::get('/{id}/finished-goods', [InvoiceDeliveredController::class, 'getFinishedGoods'])->name('sales.invoice.deliver.get-all-finished-goods')->middleware('permission:deliver-items');
    Route::get('/{id}/deliver/{barcode}/{count}', [InvoiceDeliveredController::class, 'checkBarCode'])->name('sales.invoice.deliver.check-barcode')->middleware('permission:deliver-items');

});

