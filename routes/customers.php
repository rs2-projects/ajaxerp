<?php

use App\Http\Controllers\Sales\CustomerController;
use Illuminate\Support\Facades\Route;
//customer routes start
Route::prefix('customers')->group(function(){

    Route::get('/', [CustomerController::class, 'index'])->name('sales.customer.index');
    Route::post('/filtered', [CustomerController::class, 'indexFiltered'])->name('sales.customer.filtered');
    Route::get('/create', [CustomerController::class, 'create'])->name('sales.customer.create');
    Route::post('/create', [CustomerController::class, 'store'])->name('sales.customer.store');
    Route::get('/{id}/edit', [CustomerController::class, 'edit'])->name('sales.customer.edit');
    Route::post('/{id}/update', [CustomerController::class, 'update'])->name('sales.customer.update');
    Route::get('/{id}/delete', [CustomerController::class, 'delete'])->name('sales.customer.delete');
    Route::get('/get-states-by-country', [CustomerController::class, 'getStatesByCountry'])->name('sales.customer.get-states-by-country');
});
//customer routes end
