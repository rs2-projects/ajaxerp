<?php

use App\Http\Controllers\Sales\InvoiceController;
use Illuminate\Support\Facades\Route;

Route::prefix('invoice')->group(function(){
    Route::get('/',[InvoiceController::class,'index'])->name('sales.invoice.index');
    Route::get('/filtered',[InvoiceController::class,'indexFiltered'])->name('sales.invoice.filtered');
    Route::get('/create',[InvoiceController::class,'create'])->name('sales.invoice.create');
    Route::post('/create',[InvoiceController::class,'store'])->name('sales.invoice.store');
    Route::get('/{id}/edit',[InvoiceController::class,'edit'])->name('sales.invoice.edit');
    Route::get('/{id}/update',[InvoiceController::class,'update'])->name('sales.invoice.update');
});
