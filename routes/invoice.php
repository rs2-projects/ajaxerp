<?php

use App\Http\Controllers\Sales\InvoiceController;
use App\Http\Controllers\Sales\InvoiceDeliveredController;
use App\Http\Controllers\Sales\InvoiceDesignController;
use Illuminate\Support\Facades\Route;

Route::prefix('invoice')->group(function(){
    Route::get('/',[InvoiceController::class,'index'])->name('sales.invoice.index');
    //Filter invoice data
    Route::post('/filtered',[InvoiceController::class,'indexFilteredData'])->name('sales.invoice.filtered');
    Route::get('/get-all-customer',[InvoiceController::class,'getAllCustomer'])->name('sales.invoice.get-all-customer');
    Route::get('/get-all-finished-goods',[InvoiceController::class,'getAllFinishedGoods'])->name('sales.invoice.get-all-finished-goods');
    Route::get('/get-all-taxes',[InvoiceController::class,'getAllTaxes'])->name('sales.invoice.get-all-taxes');
    Route::get('/get-design/{id}',[InvoiceController::class,'getDesign'])->name('sales.invoice.design');
    //create invoice data
    Route::get('/create',[InvoiceController::class,'create'])->name('sales.invoice.create');
    Route::post('/create',[InvoiceController::class,'store'])->name('sales.invoice.store');
    // make payment
    Route::get('/{id}/make-payment', [InvoiceController::class, 'makePayment'])->name('sales.invoice.make-payment');
    Route::post('/{id}/make-payment-submit', [InvoiceController::class, 'makePaymentSubmit'])->name('sales.invoice.make-payment-submit');
    //Edit invoice data
    Route::get('/{id}/edit',[InvoiceController::class,'edit'])->name('sales.invoice.edit');
    Route::get('/{id}/get-edit-invoice-data',[InvoiceController::class,'getEditInvoiceData'])->name('sales.invoice.get-edit-invoice-data');
    //update invoice data
    Route::post('/{id}/update',[InvoiceController::class,'update'])->name('sales.invoice.update');
    //Delete invoice
    Route::get('/{id}/delete',[InvoiceController::class,'delete'])->name('sales.invoice.delete');
    //Upload invoice design
    Route::post('/upload-design',[InvoiceDesignController::class,'uploadDesign'])->name('sales.invoice.design_upload');
    //Design delete
    Route::get('/{id}/delete-design',[InvoiceController::class,'deleteDesign'])->name('sales.invoice.design.delete');
    //Invoice delivered
    Route::get('/{id}/deliver', [InvoiceDeliveredController::class, 'deliver'])->name('sales.invoice.deliver');
    Route::post('/{id}/deliver', [InvoiceDeliveredController::class, 'deliverStore'])->name('sales.invoice.deliver.store');
    Route::get('/{id}/finished-goods', [InvoiceDeliveredController::class, 'getFinishedGoods'])->name('sales.invoice.deliver.get-all-finished-goods');
    Route::get('/{id}/deliver/{barcode}/{count}', [InvoiceDeliveredController::class, 'checkBarCode'])->name('sales.invoice.deliver.check-barcode');

});

