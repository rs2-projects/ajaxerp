<?php

use App\Http\Controllers\Procurement\ProductMaterial\ProductMaterialPurchaseController;
use App\Http\Controllers\Procurement\ProductMaterial\PurchaseInvestigationController;
use App\Http\Controllers\Procurement\ProductMaterial\PurchaseMakePaymentController;
use App\Http\Controllers\Procurement\ProductMaterial\PurchaseOrderCalculatePriceController;
use App\Http\Controllers\Procurement\Assets\UserPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\AdminPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\PuchaseOrderPaymentController;
use App\Http\Controllers\Procurement\Assets\PurchaseOrderController;
use App\Http\Controllers\Procurement\Supplier\SupplierController;
use Illuminate\Support\Facades\Route;

// Procurement route start
Route::group(['prefix' => 'procurement'], function (){
    // product-material-purchase route start
    Route::group(['prefix' => 'product-material-purchase'], function () {
        Route::get('/', [ProductMaterialPurchaseController::class, 'index'])->name('procurement.product-material-purchase.index')->middleware('permission:view-product-material-purchase-orders');
        Route::post('/filtered', [ProductMaterialPurchaseController::class, 'indexFiltered'])->name('procurement.product-material-purchase.filtered')->middleware('permission:view-product-material-purchase-orders');
        Route::get('{id}/details', [ProductMaterialPurchaseController::class, 'show'])->name('procurement.product-material-purchase.details')->middleware('permission:view-product-material-purchase-orders');
        Route::get('/create', [ProductMaterialPurchaseController::class, 'create'])->name('procurement.product-material-purchase.create')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/create', [ProductMaterialPurchaseController::class, 'store'])->name('procurement.product-material-purchase.store')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/{id}/edit', [ProductMaterialPurchaseController::class, 'edit'])->name('procurement.product-material-purchase.edit')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/{id}/edit-purchase-data-get', [ProductMaterialPurchaseController::class, 'getEditPurchaseData'])->name('procurement.product-material-purchase.get-edit-purchase-data')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{id}/update', [ProductMaterialPurchaseController::class, 'update'])->name('procurement.product-material-purchase.update')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/{id}/delete', [ProductMaterialPurchaseController::class, 'delete'])->name('procurement.product-material-purchase.delete')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/{id}/change-status/{status}', [ProductMaterialPurchaseController::class, 'statusUpdate'])->name('procurement.product-material-purchase.change-status')->middleware('permission:manage-product-material-purchase-orders');

        // create and back purchase order
        Route::get('/{id}/create-revised-order', [ProductMaterialPurchaseController::class, 'createRevisedOrder'])->name('procurement.product-material-purchase.create-revised-order')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{id}/create-revised-order', [ProductMaterialPurchaseController::class, 'storeRevisedOrder'])->name('procurement.product-material-purchase.store-revised-order')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/{id}/create-back-order', [ProductMaterialPurchaseController::class, 'createBackOrder'])->name('procurement.product-material-purchase.create-back-order')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{id}/create-back-order', [ProductMaterialPurchaseController::class, 'storeBackOrder'])->name('procurement.product-material-purchase.store-back-order')->middleware('permission:manage-product-material-purchase-orders');

        Route::get('/get-all-product-materials',[ProductMaterialPurchaseController::class, 'getAllProductMaterials'])->name('procurement.product-material-purchase.get-all-product-materials')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/get-all-taxes',[ProductMaterialPurchaseController::class, 'getAllTaxes'])->name('procurement.product-material-purchase.get-all-taxes')->middleware('permission:manage-product-material-purchase-orders');
        Route::get('/get-all-suppliers',[ProductMaterialPurchaseController::class, 'getAllSuppliers'])->name('procurement.product-material-purchase.get-all-suppliers')->middleware('permission:manage-product-material-purchase-orders');

        // make payment
        Route::get('/{id}/make-payment', [PurchaseMakePaymentController::class, 'makePayment'])->name('procurement.product-material-purchase.make-payment')->middleware('permission:product-material-purchase-order-payment');
        Route::post('/{id}/make-payment-submit', [PurchaseMakePaymentController::class, 'makePaymentSubmit'])->name('procurement.product-material-purchase.make-payment-submit')->middleware('permission:product-material-purchase-order-payment');

        // calculate others price
        Route::get('/{purchase_id}/others/calculate-price', [PurchaseOrderCalculatePriceController::class, 'index'])->name('procurement.purchase-order.calculate-price.index')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{purchase_id}/others/calculate-price/store', [PurchaseOrderCalculatePriceController::class, 'store'])->name('procurement.purchase-order.calculate-price.store')->middleware('permission:manage-product-material-purchase-orders');
        // calculate price boards
        Route::get('/{purchase_id}/board/calculate-price', [PurchaseOrderCalculatePriceController::class, 'showBoardCalculateForm'])->name('procurement.purchase-order.board.calculate-price.index')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{purchase_id}/board/calculate-price/store', [PurchaseOrderCalculatePriceController::class, 'storeBoardCalculateForm'])->name('procurement.purchase-order.board.calculate-price.store')->middleware('permission:manage-product-material-purchase-orders');

        // print barcode
        Route::get('/{id}/get-print-barcode-data/{type}', [ProductMaterialPurchaseController::class, 'printBarcodeData'])->name('procurement.product-material-purchase.print-barcode-data')->middleware('permission:product-material-purchase-print-barcode');
        Route::post('/print-barcode', [ProductMaterialPurchaseController::class, 'printBarcode'])->name('procurement.product-material-purchase.print-barcode')->middleware('permission:product-material-purchase-print-barcode');
    });
    // materials purchase order route end

    // purchase investigation route start
    Route::group(['prefix' => 'purchase-investigation'], function () {
        Route::get('/{purchase_id}', [PurchaseInvestigationController::class, 'index'])->name('procurement.purchase-investigation.index')->middleware('permission:manage-product-material-purchase-orders');
        Route::post('/{purchase_id}/update', [PurchaseInvestigationController::class, 'update'])->name('procurement.purchase-investigation.update')->middleware('permission:manage-product-material-purchase-orders');
    });

    // suppliers route start
    Route::group(['prefix' => 'supplier'], function () {
        Route::get('/', [SupplierController::class, 'index'])->name('procurement.supplier.index')->middleware('permission:view-suppliers');
        Route::post('/filtered', [SupplierController::class, 'indexFiltered'])->name('procurement.supplier.filtered')->middleware('permission:view-suppliers');
        Route::get('/create', [SupplierController::class, 'create'])->name('procurement.supplier.create')->middleware('permission:manage-suppliers');
        Route::post('/create', [SupplierController::class, 'store'])->name('procurement.supplier.store')->middleware('permission:manage-suppliers');
        Route::get('/{id}/edit', [SupplierController::class, 'edit'])->name('procurement.supplier.edit')->middleware('permission:manage-suppliers');
        Route::post('/{id}/update', [SupplierController::class, 'update'])->name('procurement.supplier.update')->middleware('permission:manage-suppliers');
        Route::get('/{id}/delete', [SupplierController::class, 'delete'])->name('procurement.supplier.delete')->middleware('permission:manage-suppliers');
        Route::get('/{id}/change-status/{status}', [SupplierController::class, 'statusUpdate'])->name('procurement.supplier.change-status')->middleware('permission:manage-suppliers');
        Route::get('/get-states-by-country', [SupplierController::class, 'getStatesByCountry'])->name('procurement.supplier.get-states-by-country')->middleware('permission:manage-suppliers');
    });

    //user purchase request route start
    Route::group(['prefix' => 'asset-purchase-request', 'middleware' => 'permission:create-asset-product-purchase-request'], function () {
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
        Route::get('/', [AdminPurchaseRequestController::class, 'index'])->name('procurement.admin.asset-purchase-request.index')->middleware('permission:view-asset-product-purchase-request');
        Route::post('/filtered', [AdminPurchaseRequestController::class, 'indexFiltered'])->name('procurement.admin.asset-purchase-request.filtered')->middleware('permission:view-asset-product-purchase-request');
        Route::get('/{id}/details', [AdminPurchaseRequestController::class, 'details'])->name('procurement.admin.asset-purchase-request.request-details')->middleware('permission:view-asset-product-purchase-request');
        Route::post('/{id}/details/store', [AdminPurchaseRequestController::class, 'storeRequestedInfo'])->name('procurement.admin.asset-purchase-request.request-details.store')->middleware('permission:manage-asset-product-purchase-request');
        Route::get('/{id}/approved-requests', [AdminPurchaseRequestController::class, 'approvedDetails'])->name('procurement.admin.asset-purchase-request.approved-request-details')->middleware('permission:view-asset-product-purchase-request');
        Route::get('/{id}/delete', [AdminPurchaseRequestController::class, 'delete'])->name('procurement.admin.asset-purchase-request.delete')->middleware('permission:manage-asset-product-purchase-request');
        Route::get('/{id}/approve', [AdminPurchaseRequestController::class, 'approve'])->name('procurement.admin.asset-purchase-request.approve')->middleware('permission:manage-asset-product-purchase-request');
        Route::get('/{id}/decline', [AdminPurchaseRequestController::class, 'decline'])->name('procurement.admin.asset-purchase-request.decline')->middleware('permission:manage-asset-product-purchase-request');
    });
    //admin purchase request route end

    // asset purchase order start
    Route::group(['prefix' => 'asset-purchase-order'], function () {
        Route::get('/', [PurchaseOrderController::class, 'index'])->name('procurement.asset-purchase-order.index')->middleware('permission:view-asset-product-purchase-orders');
        Route::post('/filtered', [PurchaseOrderController::class, 'indexFiltered'])->name('procurement.asset-purchase-order.filtered')->middleware('permission:view-asset-product-purchase-orders');
        Route::get('/create', [PurchaseOrderController::class, 'create'])->name('procurement.asset-purchase-order.create')->middleware('permission:manage-asset-product-purchase-orders');
        Route::post('/create', [PurchaseOrderController::class, 'store'])->name('procurement.asset-purchase-order.store')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/selected-purchase-data-get', [PurchaseOrderController::class, 'getSelectedPurchaseData'])->name('procurement.asset-purchase-order.get-selected-purchase-data')->middleware('permission:manage-asset-product-purchase-orders');

        // edit
        Route::get('/{id}/edit', [PurchaseOrderController::class, 'edit'])->name('procurement.asset-purchase-order.edit')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/{id}/get-edit-purchase-data', [PurchaseOrderController::class, 'getEditPurchaseData'])->name('procurement.asset-purchase-order.get-edit-purchase-data')->middleware('permission:manage-asset-product-purchase-orders');
        Route::post('/{id}/update', [PurchaseOrderController::class, 'update'])->name('procurement.asset-purchase-order.update')->middleware('permission:manage-asset-product-purchase-orders');

        Route::get('/get-all-asset-products',[PurchaseOrderController::class, 'getAllAssetProducts'])->name('procurement.asset-purchase-order.get-all-asset-products')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/get-all-taxes',[PurchaseOrderController::class, 'getAllTaxes'])->name('procurement.asset-purchase-order.get-all-taxes')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/get-all-suppliers',[PurchaseOrderController::class, 'getAllSuppliers'])->name('procurement.asset-purchase-order.get-all-suppliers')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/{id}/delete', [PurchaseOrderController::class, 'delete'])->name('procurement.asset-purchase-order.delete')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/{id}/cancel', [PurchaseOrderController::class, 'cancel'])->name('procurement.asset-purchase-order.cancel')->middleware('permission:manage-asset-product-purchase-orders');
        Route::get('/{id}/change-status/{status}', [PurchaseOrderController::class, 'statusUpdate'])->name('procurement.asset-purchase-order.change-status')->middleware('permission:manage-asset-product-purchase-orders');

        // investigation
        Route::get('/{purchase_id}/investigate', [PurchaseOrderController::class, 'investigate'])->name('procurement.asset-purchase-order.investigate')->middleware('permission:manage-asset-product-purchase-orders');
        Route::post('/{purchase_id}/investigate', [PurchaseOrderController::class, 'investigateStore'])->name('procurement.asset-purchase-order.investigate.store')->middleware('permission:manage-asset-product-purchase-orders');

        // make payment
        Route::get('/{id}/make-payment', [PuchaseOrderPaymentController::class, 'makePayment'])->name('procurement.asset-purchase-order.make-payment')->middleware('permission:asset-product-purchase-order-payment');
        Route::post('/{id}/make-payment-submit', [PuchaseOrderPaymentController::class, 'makePaymentSubmit'])->name('procurement.asset-purchase-order.make-payment-submit')->middleware('permission:asset-product-purchase-order-payment');
    });
    // asset purchase order end
});
// Procurement route End
