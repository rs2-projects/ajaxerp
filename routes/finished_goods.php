<?php

use App\Http\Controllers\Inventory\FinishedGoodCategoryController;
use App\Http\Controllers\Inventory\FinishedGoodController;
use Illuminate\Support\Facades\Route;
 //Finished Good Route Start
 Route::prefix('inventory')->group(function () {
     //finished good category route
     Route::prefix('finished-good-category')->group(function (){
         Route::get('/', [FinishedGoodCategoryController::class, 'index'])->name('inventory.finished-good-category.index');
         Route::post('/filtered', [FinishedGoodCategoryController::class, 'indexFiltered'])->name('inventory.finished-good-category.filtered');
         Route::get('/create', [FinishedGoodCategoryController::class, 'create'])->name('inventory.finished-good-category.create');
         Route::post('/store', [FinishedGoodCategoryController::class, 'store'])->name('inventory.finished-good-category.store');
         Route::get('/{id}/edit', [FinishedGoodCategoryController::class, 'edit'])->name('inventory.finished-good-category.edit');
         Route::post('/{id}/update', [FinishedGoodCategoryController::class, 'update'])->name('inventory.finished-good-category.update');
         Route::get('/{id}/delete', [FinishedGoodCategoryController::class, 'delete'])->name('inventory.finished-good-category.delete');
     });
     //finished good route
     Route::prefix('finished-good')->group(function (){
         Route::get('/', [FinishedGoodController::class, 'index'])->name('inventory.finished-good.index');
         Route::post('/filtered', [FinishedGoodController::class, 'indexFiltered'])->name('inventory.finished-good.filtered');
         Route::get('/create', [FinishedGoodController::class, 'create'])->name('inventory.finished-good.create');
         Route::post('/store', [FinishedGoodController::class, 'store'])->name('inventory.finished-good.store');
         Route::get('/{id}/edit', [FinishedGoodController::class, 'edit'])->name('inventory.finished-good.edit');
         Route::post('/{id}/update', [FinishedGoodController::class, 'update'])->name('inventory.finished-good.update');
         Route::get('/{id}/purchase-history', [FinishedGoodController::class, 'purchaseHistory'])->name('inventory.finished-good.purchase-history');
         Route::get('/{id}/delete', [FinishedGoodController::class, 'delete'])->name('inventory.finished-good.delete');
         Route::get('/{id}/change-status/{status}', [FinishedGoodController::class, 'statusUpdate'])->name('inventory.finished-good.change-status');
         Route::get('/get-sections-by-warehouse', [FinishedGoodController::class, 'getSectionsByWarehouse'])->name('inventory.finished-good.get-sections-by-warehouse');
         Route::get('/get-racks-by-sections', [FinishedGoodController::class, 'getRacksBySections'])->name('inventory.finished-good.get-racks-by-sections');
     });
 });
//Finished Good Route End
