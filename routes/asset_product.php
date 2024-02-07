<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\AssetProductCategoryController;
use App\Http\Controllers\Inventory\AssetProductController;
use App\Http\Controllers\Procurement\Assets\UserPurchaseRequestController;
use App\Http\Controllers\Procurement\Supplier\SupplierController;

Route::group(['prefix' => 'inventory'], function () {
    // asset product category route start
    Route::group(['prefix' => 'asset-product-category'], function () {
        Route::get('/', [AssetProductCategoryController::class, 'index'])->name('inventory.asset-product-category.index');
        Route::post('/filtered', [AssetProductCategoryController::class, 'indexFiltered'])->name('inventory.asset-product-category.filtered');
        Route::get('/create', [AssetProductCategoryController::class, 'create'])->name('inventory.asset-product-category.create');
        Route::post('/create', [AssetProductCategoryController::class, 'store'])->name('inventory.asset-product-category.store');
        Route::get('/{id}/edit', [AssetProductCategoryController::class, 'edit'])->name('inventory.asset-product-category.edit');
        Route::post('/{id}/update', [AssetProductCategoryController::class, 'update'])->name('inventory.asset-product-category.update');
        Route::get('/{id}/delete', [AssetProductCategoryController::class, 'delete'])->name('inventory.asset-product-category.delete');
        Route::get('/{id}/change-status/{status}', [AssetProductCategoryController::class, 'statusUpdate'])->name('inventory.asset-product-category.change-status');
    });

    // asset products route start
    Route::group(['prefix' => 'asset-product'], function () {
        Route::get('/', [AssetProductController::class, 'index'])->name('inventory.asset-product.index');
        Route::post('/filtered', [AssetProductController::class, 'indexFiltered'])->name('inventory.asset-product.filtered');
        Route::get('/create', [AssetProductController::class, 'create'])->name('inventory.asset-product.create');
        Route::post('/create', [AssetProductController::class, 'store'])->name('inventory.asset-product.store');
        Route::get('/{id}/edit', [AssetProductController::class, 'edit'])->name('inventory.asset-product.edit');
        Route::post('/{id}/update', [AssetProductController::class, 'update'])->name('inventory.asset-product.update');
        Route::get('/{id}/delete', [AssetProductController::class, 'delete'])->name('inventory.asset-product.delete');
        Route::get('/{id}/change-status/{status}', [AssetProductController::class, 'statusUpdate'])->name('inventory.asset-product.change-status');
    });
});


Route::group(['prefix' => 'procurement'], function () {
    // suppliers route start
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index'])->name('procurement.supplier.index');
        Route::post('/filtered', [SupplierController::class, 'indexFiltered'])->name('procurement.supplier.filtered');
        Route::get('/create', [SupplierController::class, 'create'])->name('procurement.supplier.create');
        Route::post('/create', [SupplierController::class, 'store'])->name('procurement.supplier.store');
        Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('procurement.supplier.edit');
        Route::post('/{id}/update', [SupplierController::class, 'update'])->name('procurement.supplier.update');
        Route::get('/{id}/delete', [SupplierController::class, 'delete'])->name('procurement.supplier.delete');
        Route::get('/{id}/change-status/{status}', [SupplierController::class, 'statusUpdate'])->name('procurement.supplier.change-status');
        Route::get('/get-states-by-country', [SupplierController::class, 'getStatesByCountry'])->name('procurement.supplier.get-states-by-country');
    });

    //user purchase request route start
    Route::group(['prefix' => 'asset-purchase-request'], function () {
        Route::get('/', [UserPurchaseRequestController::class, 'index'])->name('procurement.user.asset-purchase-request.index');
        Route::post('/filtered', [UserPurchaseRequestController::class, 'indexFiltered'])->name('procurement.user.asset-purchase-request.filtered');
        Route::get('/create', [UserPurchaseRequestController::class, 'create'])->name('procurement.user.asset-purchase-request.create');
        Route::post('/create', [UserPurchaseRequestController::class, 'store'])->name('procurement.user.asset-purchase-request.store');
        Route::get('/{id}/edit', [UserPurchaseRequestController::class, 'edit'])->name('procurement.user.asset-purchase-request.edit');
        Route::post('/{id}/update', [UserPurchaseRequestController::class, 'update'])->name('procurement.user.asset-purchase-request.update');
        Route::get('/{id}/delete', [UserPurchaseRequestController::class, 'delete'])->name('procurement.user.asset-purchase-request.delete');
        Route::get('/asset-products-by-category', [UserPurchaseRequestController::class, 'getAssetProducts'])->name('procurement.asset-purchase-request.products-by-category');
    });
});
