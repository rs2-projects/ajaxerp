<?php

use App\Http\Controllers\Inventory\FinishedGoodCategoryController;
use App\Http\Controllers\Inventory\FinishedGoodController;
use App\Http\Controllers\Inventory\ReceiveProductController;
use Illuminate\Support\Facades\Route;
 //Finished Good Route Start
 Route::prefix('inventory')->group(function () {
     //finished good category route
     Route::prefix('finished-good-category')->group(function (){
         Route::get('/', [FinishedGoodCategoryController::class, 'index'])->name('inventory.finished-good-category.index')->middleware('permission:view-finished-goods-category');
         Route::post('/filtered', [FinishedGoodCategoryController::class, 'indexFiltered'])->name('inventory.finished-good-category.filtered')->middleware('permission:view-finished-goods-category');
         Route::get('/create', [FinishedGoodCategoryController::class, 'create'])->name('inventory.finished-good-category.create')->middleware('permission:manage-finished-goods-category');
         Route::post('/store', [FinishedGoodCategoryController::class, 'store'])->name('inventory.finished-good-category.store')->middleware('permission:manage-finished-goods-category');
         Route::get('/{id}/edit', [FinishedGoodCategoryController::class, 'edit'])->name('inventory.finished-good-category.edit')->middleware('permission:manage-finished-goods-category');
         Route::post('/{id}/update', [FinishedGoodCategoryController::class, 'update'])->name('inventory.finished-good-category.update')->middleware('permission:manage-finished-goods-category');
         Route::get('/{id}/delete', [FinishedGoodCategoryController::class, 'delete'])->name('inventory.finished-good-category.delete')->middleware('permission:manage-finished-goods-category');
     });
     //finished good route
     Route::prefix('finished-good')->group(function (){
         Route::get('/', [FinishedGoodController::class, 'index'])->name('inventory.finished-good.index')->middleware('permission:view-finished-goods');
         Route::post('/filtered', [FinishedGoodController::class, 'indexFiltered'])->name('inventory.finished-good.filtered')->middleware('permission:view-finished-goods');
         Route::get('/create', [FinishedGoodController::class, 'create'])->name('inventory.finished-good.create')->middleware('permission:manage-finished-goods');
         Route::post('/store', [FinishedGoodController::class, 'store'])->name('inventory.finished-good.store')->middleware('permission:manage-finished-goods');
         Route::get('/{id}/edit', [FinishedGoodController::class, 'edit'])->name('inventory.finished-good.edit')->middleware('permission:manage-finished-goods');
         Route::post('/{id}/update', [FinishedGoodController::class, 'update'])->name('inventory.finished-good.update')->middleware('permission:manage-finished-goods');
         Route::get('/{id}/purchase-history', [FinishedGoodController::class, 'purchaseHistory'])->name('inventory.finished-good.purchase-history')->middleware('permission:view-finished-goods');
         Route::get('/{id}/delete', [FinishedGoodController::class, 'delete'])->name('inventory.finished-good.delete')->middleware('permission:manage-finished-goods');
         Route::get('/{id}/change-status/{status}', [FinishedGoodController::class, 'statusUpdate'])->name('inventory.finished-good.change-status')->middleware('permission:manage-finished-goods');
         Route::get('/get-sections-by-warehouse', [FinishedGoodController::class, 'getSectionsByWarehouse'])->name('inventory.finished-good.get-sections-by-warehouse')->middleware('permission:manage-finished-goods');
         Route::get('/get-racks-by-sections', [FinishedGoodController::class, 'getRacksBySections'])->name('inventory.finished-good.get-racks-by-sections')->middleware('permission:manage-finished-goods');
     });

     // receive products
    Route::group(['prefix' => 'receive-products'], function () {
        Route::get('/', [ReceiveProductController::class, 'index'])->name('inventory.receive-product.index')->middleware('permission:view-received-products');
        Route::post('/filtered', [ReceiveProductController::class, 'indexFiltered'])->name('inventory.receive-product.filtered')->middleware('permission:view-received-products');
        Route::get('/{id}/receive', [ReceiveProductController::class, 'receive'])->name('inventory.receive-product.receive')->middleware('permission:receive-products');
        Route::post('/{id}/dispatch', [ReceiveProductController::class, 'receiveStore'])->name('inventory.receive-product.receive.store')->middleware('permission:receive-products');
    });
 });
//Finished Good Route End
