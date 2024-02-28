<?php

use App\Http\Controllers\Sales\InvoiceController;
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
});
