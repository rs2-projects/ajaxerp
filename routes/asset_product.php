<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\AssetProductCategoryController;
use App\Http\Controllers\Inventory\AssetProductController;
use App\Http\Controllers\Procurement\Assets\UserPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\AdminPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\PuchaseOrderPaymentController;
use App\Http\Controllers\Procurement\Assets\PurchaseOrderController;
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
        Route::get('/{id}/add-more-info', [UserPurchaseRequestController::class, 'addMoreInfo'])->name('procurement.user.asset-purchase-request.add-more-info');
        Route::post('/{id}/add-more-info/store', [UserPurchaseRequestController::class, 'storAddMoreInfo'])->name('procurement.user.asset-purchase-request.add-more-info.update');
        Route::get('/{id}/delete', [UserPurchaseRequestController::class, 'delete'])->name('procurement.user.asset-purchase-request.delete');
        Route::get('/asset-products-by-category', [UserPurchaseRequestController::class, 'getAssetProducts'])->name('procurement.asset-purchase-request.products-by-category');
    });

    //admin purchase request route start
    Route::group(['prefix' => 'admin/asset-purchase-request'], function () {
        Route::get('/', [AdminPurchaseRequestController::class, 'index'])->name('procurement.admin.asset-purchase-request.index');
        Route::post('/filtered', [AdminPurchaseRequestController::class, 'indexFiltered'])->name('procurement.admin.asset-purchase-request.filtered');
        Route::get('/{id}/details', [AdminPurchaseRequestController::class, 'details'])->name('procurement.admin.asset-purchase-request.request-details');
        Route::post('/{id}/details/store', [AdminPurchaseRequestController::class, 'storeRequestedInfo'])->name('procurement.admin.asset-purchase-request.request-details.store');
        Route::get('/{id}/approved-requests', [AdminPurchaseRequestController::class, 'approvedDetails'])->name('procurement.admin.asset-purchase-request.approved-request-details');
        Route::get('/{id}/delete', [AdminPurchaseRequestController::class, 'delete'])->name('procurement.admin.asset-purchase-request.delete');
        Route::get('/{id}/approve', [AdminPurchaseRequestController::class, 'approve'])->name('procurement.admin.asset-purchase-request.approve');
        Route::get('/{id}/decline', [AdminPurchaseRequestController::class, 'decline'])->name('procurement.admin.asset-purchase-request.decline');
    });
    //admin purchase request route end

    // asset purchase order
    Route::group(['prefix' => 'asset-purchase-order'], function () {
        Route::get('/', [PurchaseOrderController::class, 'index'])->name('procurement.asset-purchase-order.index');
        Route::post('/filtered', [PurchaseOrderController::class, 'indexFiltered'])->name('procurement.asset-purchase-order.filtered');
        Route::get('/create', [PurchaseOrderController::class, 'create'])->name('procurement.asset-purchase-order.create');
        Route::post('/create', [PurchaseOrderController::class, 'store'])->name('procurement.asset-purchase-order.store');
        Route::get('/selected-purchase-data-get', [PurchaseOrderController::class, 'getSelectedPurchaseData'])->name('procurement.asset-purchase-order.get-selected-purchase-data');

        // edit 
        Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('procurement.asset-purchase-order.edit');
        Route::get('/{id}/get-edit-purchase-data', [PurchaseOrderController::class, 'getEditPurchaseData'])->name('procurement.asset-purchase-order.get-edit-purchase-data');
        Route::post('/{id}/update', [PurchaseOrderController::class, 'update'])->name('procurement.asset-purchase-order.update');
            
        Route::get('/get-all-asset-products',[PurchaseOrderController::class, 'getAllAssetProducts'])->name('procurement.asset-purchase-order.get-all-asset-products');
        Route::get('/get-all-taxes',[PurchaseOrderController::class, 'getAllTaxes'])->name('procurement.asset-purchase-order.get-all-taxes');
        Route::get('/get-all-suppliers',[PurchaseOrderController::class, 'getAllSuppliers'])->name('procurement.asset-purchase-order.get-all-suppliers');
        Route::get('/{id}/delete', [PurchaseOrderController::class, 'delete'])->name('procurement.asset-purchase-order.delete');
        Route::get('/{id}/cancel', [PurchaseOrderController::class, 'cancel'])->name('procurement.asset-purchase-order.cancel');
        Route::get('/{id}/change-status/{status}', [PurchaseOrderController::class, 'statusUpdate'])->name('procurement.asset-purchase-order.change-status');

        // investigation
        Route::get('/{purchase_id}/investigate', [PurchaseOrderController::class, 'investigate'])->name('procurement.asset-purchase-order.investigate');
        Route::post('/{purchase_id}/investigate', [PurchaseOrderController::class, 'investigateStore'])->name('procurement.asset-purchase-order.investigate.store');
    
        // make payment
        Route::get('/{id}/make-payment', [PuchaseOrderPaymentController::class, 'makePayment'])->name('procurement.asset-purchase-order.make-payment');
        Route::post('/{id}/make-payment-submit', [PuchaseOrderPaymentController::class, 'makePaymentSubmit'])->name('procurement.asset-purchase-order.make-payment-submit');
    });
});
