<?php

use App\Models\Products\AssetProductCategory;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'inventory'], function () {
    // asset product category route start
    Route::group(['prefix' => 'asset-product-category'], function () {
        Route::get('/', [AssetProductCategory::class, 'index'])->name('inventory.asset-product-category.index');
        Route::post('/filtered', [AssetProductCategory::class, 'indexFiltered'])->name('inventory.asset-product-category.filtered');
        Route::get('/create', [AssetProductCategory::class, 'create'])->name('inventory.asset-product-category.create');
        Route::post('/create', [AssetProductCategory::class, 'store'])->name('inventory.asset-product-category.store');
        Route::get('/{id}/edit', [AssetProductCategory::class, 'edit'])->name('inventory.asset-product-category.edit');
        Route::post('/{id}/update', [AssetProductCategory::class, 'update'])->name('inventory.asset-product-category.update');
        Route::get('/{id}/delete', [AssetProductCategory::class, 'delete'])->name('inventory.asset-product-category.delete');
        Route::get('/{id}/change-status/{status}', [AssetProductCategory::class, 'statusUpdate'])->name('inventory.asset-product-category.change-status');
    });
});
