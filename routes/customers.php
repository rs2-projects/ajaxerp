<?php

use App\Http\Controllers\Sales\CustomerController;
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
