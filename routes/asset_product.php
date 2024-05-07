<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Inventory\AssetProductCategoryController;
use App\Http\Controllers\Inventory\AssetProductController;
use App\Http\Controllers\Inventory\BoardsController;
use App\Http\Controllers\Procurement\Assets\UserPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\AdminPurchaseRequestController;
use App\Http\Controllers\Procurement\Assets\PuchaseOrderPaymentController;
use App\Http\Controllers\Procurement\Assets\PurchaseOrderController;
use App\Http\Controllers\Procurement\Supplier\SupplierController;
use App\Http\Controllers\Production\Machine\MachineController;
use App\Http\Controllers\Production\PreProduction\PreProductionController;
use App\Http\Controllers\Settings\UserRoleController;
use App\Http\Controllers\Settings\UserRolePermissionController;
use App\Http\Controllers\Inventory\PreProductionMaterialRequestController;
use App\Http\Controllers\Inventory\ReceiveProductController;
use App\Http\Controllers\Production\BoardPreProduction\BoardPreProductionController;
use App\Http\Controllers\Production\BoardProduction\BoardProductionController;
use App\Http\Controllers\Production\Production\ProductionController;
use App\Http\Controllers\Production\ProductionStaff\ProductionStaffController;
use App\Http\Controllers\Settings\BoardColorController;
use App\Http\Controllers\Settings\BoardEmbossedController;

Route::group(['prefix' => 'inventory'], function () {
    // asset product category route start
    Route::group(['prefix' => 'asset-product-category'], function () {
        Route::get('/', [AssetProductCategoryController::class, 'index'])->name('inventory.asset-product-category.index')->middleware('permission:view-asset-product-category');
        Route::post('/filtered', [AssetProductCategoryController::class, 'indexFiltered'])->name('inventory.asset-product-category.filtered')->middleware('permission:view-asset-product-category');
        Route::get('/create', [AssetProductCategoryController::class, 'create'])->name('inventory.asset-product-category.create')->middleware('permission:manage-asset-product-category');
        Route::post('/create', [AssetProductCategoryController::class, 'store'])->name('inventory.asset-product-category.store')->middleware('permission:manage-asset-product-category');
        Route::get('/{id}/edit', [AssetProductCategoryController::class, 'edit'])->name('inventory.asset-product-category.edit')->middleware('permission:manage-asset-product-category');
        Route::post('/{id}/update', [AssetProductCategoryController::class, 'update'])->name('inventory.asset-product-category.update')->middleware('permission:manage-asset-product-category');
        Route::get('/{id}/delete', [AssetProductCategoryController::class, 'delete'])->name('inventory.asset-product-category.delete')->middleware('permission:manage-asset-product-category');
        Route::get('/{id}/change-status/{status}', [AssetProductCategoryController::class, 'statusUpdate'])->name('inventory.asset-product-category.change-status')->middleware('permission:manage-asset-product-category');
    });

    // asset products route start
    Route::group(['prefix' => 'asset-product'], function () {
        Route::get('/', [AssetProductController::class, 'index'])->name('inventory.asset-product.index')->middleware('permission:view-asset-product');
        Route::post('/filtered', [AssetProductController::class, 'indexFiltered'])->name('inventory.asset-product.filtered')->middleware('permission:view-asset-product');
        Route::get('/create', [AssetProductController::class, 'create'])->name('inventory.asset-product.create')->middleware('permission:manage-asset-product');
        Route::post('/create', [AssetProductController::class, 'store'])->name('inventory.asset-product.store')->middleware('permission:manage-asset-product');
        Route::get('/{id}/edit', [AssetProductController::class, 'edit'])->name('inventory.asset-product.edit')->middleware('permission:manage-asset-product');
        Route::post('/{id}/update', [AssetProductController::class, 'update'])->name('inventory.asset-product.update')->middleware('permission:manage-asset-product');
        Route::get('/{id}/delete', [AssetProductController::class, 'delete'])->name('inventory.asset-product.delete')->middleware('permission:manage-asset-product');
        Route::get('/{id}/change-status/{status}', [AssetProductController::class, 'statusUpdate'])->name('inventory.asset-product.change-status')->middleware('permission:manage-asset-product');
        
        Route::post('/{id}/assign-product', [AssetProductController::class, 'assignProduct'])->name('inventory.asset-product.assign-asset-product');
        Route::post('/{id}/maintenance-product', [AssetProductController::class, 'maintenanceProduct'])->name('inventory.asset-product.maintenance-asset-product');
        Route::post('/{id}/sell-product', [AssetProductController::class, 'sellProduct'])->name('inventory.asset-product.sell-asset-product');
        Route::post('/{id}/dispose-product', [AssetProductController::class, 'disposeProduct'])->name('inventory.asset-product.disposed-asset-product');
        Route::get('/{id}/details/{type}', [AssetProductController::class, 'assetDetails'])->name('inventory.asset-product.asset-details');
        Route::post('/{id}/return-product', [AssetProductController::class, 'returnProduct'])->name('inventory.asset-product.return-asset-product');
        Route::get('/{id}/assign-details', [AssetProductController::class, 'assignedDetails'])->name('inventory.asset-product.assigned-details');
        Route::post('/{id}/repair-product', [AssetProductController::class, 'repairProduct'])->name('inventory.asset-product.repair-asset-product');
    });

    // boards
    Route::group(['prefix' => 'boards'], function () {
        Route::get('/', [BoardsController::class, 'index'])->name('inventory.boards.index');
        Route::post('/filtered', [BoardsController::class, 'indexFiltered'])->name('inventory.boards.filtered');
        Route::post('/create', [BoardsController::class, 'store'])->name('inventory.boards.store');
        Route::get('/{id}/edit', [BoardsController::class, 'edit'])->name('inventory.boards.edit');
        Route::post('/{id}/update', [BoardsController::class, 'update'])->name('inventory.boards.update');
        Route::get('/{id}/delete', [BoardsController::class, 'delete'])->name('inventory.boards.delete');
    });


});


Route::group(['prefix' => 'procurement'], function () {
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

Route::group(['prefix' => 'settings'], function () {
    Route::group(['prefix' => 'role-management', 'middleware' => 'permission:manage-role-permission-settings'], function () {
        Route::get('/', [UserRoleController::class, 'index'])->name('settings.role-management.index');
        Route::post('/filtered', [UserRoleController::class, 'indexFiltered'])->name('settings.role-management.filtered');
        Route::get('/create', [UserRoleController::class, 'create'])->name('settings.role-management.create');
        Route::post('/create', [UserRoleController::class, 'store'])->name('settings.role-management.store');
        Route::get('/{id}/edit', [UserRoleController::class, 'edit'])->name('settings.role-management.edit');
        Route::post('/{id}/update', [UserRoleController::class, 'update'])->name('settings.role-management.update');
        Route::get('/{id}/delete', [UserRoleController::class, 'delete'])->name('settings.role-management.delete');
        Route::get('/{id}/change-status/{status}', [UserRoleController::class, 'statusUpdate'])->name('settings.role-management.change-status');
    });
    // role permission
    Route::group(['prefix' => 'role-permission', 'middleware' => 'permission:manage-role-permission-settings'], function () {
        Route::get('/{id}', [UserRolePermissionController::class, 'index'])->name('settings.role-permission.index');
        Route::post('{id}/create', [UserRolePermissionController::class, 'store'])->name('settings.role-permission.store');
      });
});

// production route start
Route::group(['prefix' => 'production'], function () {

    // Route::group(['prefix' => 'production'], function () {
        Route::get('/', [ProductionController::class, 'index'])->name('production.production.index')->middleware('permission:view-production');
        Route::post('/filtered', [ProductionController::class, 'indexFiltered'])->name('production.production.filtered')->middleware('permission:view-production');
        Route::get('/{id}/get-document', [ProductionController::class, 'getDocument'])->name('production.production.get-design-document')->middleware('permission:view-production');
        Route::get('/{id}/details', [ProductionController::class, 'details'])->name('production.production.details')->middleware('permission:view-production');
        Route::get('/{id}/change/{processId}/process-status/{status}', [ProductionController::class, 'changeProcessStatus'])->name('production.production.update-process-status')->middleware('permission:manage-processes');
        Route::get('/{id}/receive', [ProductionController::class, 'receive'])->name('production.production.receive')->middleware('permission:receive-production-materials');
        Route::post('/{id}/receive', [ProductionController::class, 'receiveStore'])->name('production.production.receive.store')->middleware('permission:receive-production-materials');
        Route::get('/{id}/get-deliveries', [ProductionController::class, 'getDeliveries'])->name('production.production.get-delivery-details')->middleware('permission:receive-production-materials');
        Route::get('/{id}/check-barcode-validity', [ProductionController::class, 'checkBarCode'])->name('production.production.check-barcode')->middleware('permission:receive-production-materials');
        Route::get('/{id}/dispatch', [ProductionController::class, 'dispatch'])->name('production.production.dispatch-data')->middleware('permission:dispatch-production-materials');
        Route::post('/{id}/dispatch', [ProductionController::class, 'dispatchStore'])->name('production.production.dispatch.store')->middleware('permission:dispatch-production-materials');
        Route::get('/{id}/print-barcode/{type}', [ProductionController::class, 'printBarcode'])->name('production.production.print-barcode')->middleware('permission:production-print-barcode');
    // });

    Route::group(['prefix' => 'machine'], function () {
        Route::get('/', [MachineController::class, 'index'])->name('production.machine.index')->middleware('permission:view-machines');
        Route::post('/filtered', [MachineController::class, 'indexFiltered'])->name('production.machine.filtered')->middleware('permission:view-machines');
        Route::get('/create', [MachineController::class, 'create'])->name('production.machine.create')->middleware('permission:manage-machines');
        Route::post('/create', [MachineController::class, 'store'])->name('production.machine.store')->middleware('permission:manage-machines');
        Route::get('/{id}/edit', [MachineController::class, 'edit'])->name('production.machine.edit')->middleware('permission:manage-machines');
        Route::post('/{id}/update', [MachineController::class, 'update'])->name('production.machine.update')->middleware('permission:manage-machines');
        Route::get('/{id}/delete', [MachineController::class, 'delete'])->name('production.machine.delete')->middleware('permission:manage-machines');
    });

    Route::group(['prefix' => 'pre-production'], function () {
        Route::get('/', [PreProductionController::class, 'index'])->name('production.pre-production.index')->middleware('permission:view-pre-productions');
        Route::post('/filtered', [PreProductionController::class, 'indexFiltered'])->name('production.pre-production.filtered')->middleware('permission:view-pre-productions');
        Route::get('/{id}/details', [PreProductionController::class, 'details'])->name('production.pre-production.details')->middleware('permission:manage-pre-productions');
        Route::get('/create', [PreProductionController::class, 'create'])->name('production.pre-production.create')->middleware('permission:manage-pre-productions');
        Route::post('/create', [PreProductionController::class, 'store'])->name('production.pre-production.store')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/edit', [PreProductionController::class, 'edit'])->name('production.pre-production.edit')->middleware('permission:manage-pre-productions');
        Route::post('/{id}/update', [PreProductionController::class, 'update'])->name('production.pre-production.update')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/delete', [PreProductionController::class, 'delete'])->name('production.pre-production.delete')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/get-material-products', [PreProductionController::class, 'getProducts'])->name('production.pre-production.get-material-products')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/get-board-products', [PreProductionController::class, 'getBoardProducts'])->name('production.pre-production.get-board-products')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/change-status/{status}', [PreProductionController::class, 'statusUpdate'])->name('production.pre-production.change-status')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/get-processes', [PreProductionController::class, 'getProcess'])->name('production.pre-production.get-all-processes')->middleware('permission:manage-pre-productions');
        Route::get('/{id}/get-document', [PreProductionController::class, 'getDocument'])->name('production.pre-production.get-design-document')->middleware('permission:view-pre-productions');
    });

    // board pre production
    Route::group(['prefix' => 'board-pre-production'], function () {
        Route::get('/', [BoardPreProductionController::class, 'index'])->name('production.board-pre-production.index');
        Route::post('/filtered', [BoardPreProductionController::class, 'indexFiltered'])->name('production.board-pre-production.filtered');
        Route::get('/create', [BoardPreProductionController::class, 'create'])->name('production.board-pre-production.create');
        Route::get('get-material-by-category', [BoardPreProductionController::class, 'getMaterialByCategory'])->name('production.board-pre-production.get-material-products');
        Route::post('/create', [BoardPreProductionController::class, 'store'])->name('production.board-pre-production.store');
        Route::get('/{id}/edit', [BoardPreProductionController::class, 'edit'])->name('production.board-pre-production.edit');
        Route::post('/{id}/update', [BoardPreProductionController::class, 'update'])->name('production.board-pre-production.update');
        Route::get('/{id}/delete', [BoardPreProductionController::class, 'delete'])->name('production.board-pre-production.delete');
        Route::get('/{id}/get-details', [BoardPreProductionController::class, 'details'])->name('production.board-pre-production.get-production-details');
        Route::post('/{id}/send-to-production', [BoardPreProductionController::class, 'sendToProduction'])->name('production.board-pre-production.send-to-production');
     });

    Route::group(['prefix' => 'production-staff'], function () {
        Route::get('/', [ProductionStaffController::class, 'index'])->name('production.production-staff.index');
        Route::post('/filtered', [ProductionStaffController::class, 'indexFiltered'])->name('production.production-staff.filtered');
        Route::get('/create', [ProductionStaffController::class, 'create'])->name('production.production-staff.create');
        Route::post('/create', [ProductionStaffController::class, 'store'])->name('production.production-staff.store');
        Route::get('/{id}/edit', [ProductionStaffController::class, 'edit'])->name('production.production-staff.edit');
        Route::post('/{id}/update', [ProductionStaffController::class, 'update'])->name('production.production-staff.update');
        Route::get('/{id}/delete', [ProductionStaffController::class, 'delete'])->name('production.production-staff.delete');
        Route::get('/{id}/change-status/{status}', [ProductionStaffController::class, 'statusUpdate'])->name('production.production-staff.change-status');
    });
});

// board production
Route::group(['prefix' => 'board-production'], function () {
    Route::get('/', [BoardProductionController::class, 'index'])->name('production.board-production.index');
    Route::post('/filtered', [BoardProductionController::class, 'indexFiltered'])->name('production.board-production.filtered');
    Route::get('/{id}/get-document', [BoardProductionController::class, 'getDocument'])->name('production.board-production.get-design-document');
    Route::get('/{id}/details', [BoardProductionController::class, 'details'])->name('production.board-production.details');
    Route::get('/{id}/change/{processId}/process-status/{status}', [BoardProductionController::class, 'changeProcessStatus'])->name('production.board-production.update-process-status');
    Route::get('/{id}/receive', [BoardProductionController::class, 'receive'])->name('production.board-production.receive');
    Route::post('/{id}/receive', [BoardProductionController::class, 'receiveStore'])->name('production.board-production.receive.store');
    Route::get('/{id}/get-deliveries', [BoardProductionController::class, 'getDeliveries'])->name('production.board-production.get-delivery-details');
    Route::get('/{id}/check-barcode-validity', [BoardProductionController::class, 'checkBarCode'])->name('production.board-production.check-barcode');
    Route::get('/{id}/dispatch', [BoardProductionController::class, 'dispatch'])->name('production.board-production.dispatch-data');
    Route::post('/{id}/dispatch', [BoardProductionController::class, 'dispatchStore'])->name('production.board-production.dispatch.store');
    Route::get('/{id}/print-barcode/{type}', [BoardProductionController::class, 'printBarcode'])->name('production.board-production.print-barcode');
});

Route::group(['prefix' => 'material-request'], function () {
    Route::get('/', [PreProductionMaterialRequestController::class, 'index'])->name('inventory.material-request.index')->middleware('permission:view-material-requests');
    Route::post('/filtered', [PreProductionMaterialRequestController::class, 'indexFiltered'])->name('inventory.material-request.filtered')->middleware('permission:view-material-requests');
    Route::get('/{id}/details', [PreProductionMaterialRequestController::class, 'details'])->name('inventory.material-request.details')->middleware('permission:view-material-requests');
    Route::get('/{id}/deliver', [PreProductionMaterialRequestController::class, 'deliver'])->name('inventory.material-request.deliver')->middleware('permission:deliver-requested-materials');
    Route::post('/{id}/deliver', [PreProductionMaterialRequestController::class, 'deliverStore'])->name('inventory.material-request.deliver.store')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/materials', [PreProductionMaterialRequestController::class, 'getMaterials'])->name('inventory.material-request.get-all-materials')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/deliver/{barcode}/{count}', [PreProductionMaterialRequestController::class, 'checkBarCode'])->name('inventory.material-request.check-barcode')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/get-document', [PreProductionMaterialRequestController::class, 'getDocument'])->name('inventory.material-request.get-design-document')->middleware('permission:view-material-requests');
});


// settings
Route::group(['prefix' => 'settings'], function () {
    // board color route start
    Route::group(['prefix' => 'board-color'], function () {
        Route::get('/', [BoardColorController::class, 'index'])->name('settings.board-color.index');
        Route::post('/filtered', [BoardColorController::class, 'indexFiltered'])->name('settings.board-color.filtered');
        Route::post('/create', [BoardColorController::class, 'store'])->name('settings.board-color.store');
        Route::get('/{id}/edit', [BoardColorController::class, 'edit'])->name('settings.board-color.edit');
        Route::post('/{id}/update', [BoardColorController::class, 'update'])->name('settings.board-color.update');
        Route::get('/{id}/delete', [BoardColorController::class, 'delete'])->name('settings.board-color.delete');
    });
    // board color route end

    // board embossed route start
    Route::group(['prefix' => 'board-embossed'], function () {
        Route::get('/', [BoardEmbossedController::class, 'index'])->name('settings.board-embossed.index');
        Route::post('/filtered', [BoardEmbossedController::class, 'indexFiltered'])->name('settings.board-embossed.filtered');
        Route::post('/create', [BoardEmbossedController::class, 'store'])->name('settings.board-embossed.store');
        Route::get('/{id}/edit', [BoardEmbossedController::class, 'edit'])->name('settings.board-embossed.edit');
        Route::post('/{id}/update', [BoardEmbossedController::class, 'update'])->name('settings.board-embossed.update');
        Route::get('/{id}/delete', [BoardEmbossedController::class, 'delete'])->name('settings.board-embossed.delete');
    });
    // board embossed route end
});