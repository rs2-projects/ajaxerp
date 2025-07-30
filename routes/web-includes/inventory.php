<?php

use App\Http\Controllers\Inventory\ProductMaterialCategoryController;
use App\Http\Controllers\Inventory\ProductMaterialController;
use App\Http\Controllers\Inventory\WarehouseController;
use App\Http\Controllers\Inventory\FinishedGoodCategoryController;
use App\Http\Controllers\Inventory\FinishedGoodController;
use App\Http\Controllers\Inventory\ReceiveProductController;
use App\Http\Controllers\Inventory\AssetProductCategoryController;
use App\Http\Controllers\Inventory\AssetProductController;
use App\Http\Controllers\Inventory\BoardsController;
use App\Http\Controllers\Inventory\DispatchInvoiceController;
use App\Http\Controllers\Inventory\ProductMaterialCartController;
use App\Http\Controllers\Inventory\ProductMaterialSetController;
use App\Http\Controllers\Inventory\ReuseItemController;
use Illuminate\Support\Facades\Route;

// inventory route start
Route::group(['prefix' => 'inventory'], function () {
    // warehouse route start
    Route::group(['prefix' => 'warehouse'], function () {
        Route::get('/', [WarehouseController::class, 'index'])->name('inventory.warehouse.index')->middleware('permission:view-warehouse');
        Route::post('/filtered', [WarehouseController::class, 'indexFiltered'])->name('inventory.warehouse.filtered')->middleware('permission:view-warehouse');
        Route::get('/create', [WarehouseController::class, 'create'])->name('inventory.warehouse.create')->middleware('permission:manage-warehouse');
        Route::post('/create', [WarehouseController::class, 'store'])->name('inventory.warehouse.store')->middleware('permission:manage-warehouse');
        Route::get('/{id}/edit', [WarehouseController::class, 'edit'])->name('inventory.warehouse.edit')->middleware('permission:manage-warehouse');
        Route::post('/{id}/update', [WarehouseController::class, 'update'])->name('inventory.warehouse.update')->middleware('permission:manage-warehouse');
        Route::get('/{id}/show', [WarehouseController::class, 'show'])->name('inventory.warehouse.show')->middleware('permission:view-warehouse');
        Route::get('/{id}/delete', [WarehouseController::class, 'delete'])->name('inventory.warehouse.delete')->middleware('permission:manage-warehouse');
        Route::get('/{id}/change-status/{status}', [WarehouseController::class, 'statusUpdate'])->name('inventory.warehouse.change-status')->middleware('permission:manage-warehouse');
    });

    // product material category route start
    Route::group(['prefix' => 'product-material-category'], function () {
        Route::get('/', [ProductMaterialCategoryController::class, 'index'])->name('inventory.product-material-category.index')->middleware('permission:view-product-material-category');
        Route::post('/filtered', [ProductMaterialCategoryController::class, 'indexFiltered'])->name('inventory.product-material-category.filtered')->middleware('permission:view-product-material-category');
        Route::get('/create', [ProductMaterialCategoryController::class, 'create'])->name('inventory.product-material-category.create')->middleware('permission:manage-product-material-category');
        Route::post('/create', [ProductMaterialCategoryController::class, 'store'])->name('inventory.product-material-category.store')->middleware('permission:manage-product-material-category');
        Route::get('/{id}/edit', [ProductMaterialCategoryController::class, 'edit'])->name('inventory.product-material-category.edit')->middleware('permission:manage-product-material-category');
        Route::post('/{id}/update', [ProductMaterialCategoryController::class, 'update'])->name('inventory.product-material-category.update')->middleware('permission:manage-product-material-category');
        Route::get('/{id}/delete', [ProductMaterialCategoryController::class, 'delete'])->name('inventory.product-material-category.delete')->middleware('permission:manage-product-material-category');
        Route::get('/{id}/change-status/{status}', [ProductMaterialCategoryController::class, 'statusUpdate'])->name('inventory.product-material-category.change-status')->middleware('permission:manage-product-material-category');
    });

    // product material route start
    Route::group(['prefix' => 'product-material'], function () {
        Route::get('/', [ProductMaterialController::class, 'index'])->name('inventory.product-material.index')->middleware('permission:view-product-material');
        Route::post('/filtered', [ProductMaterialController::class, 'indexFiltered'])->name('inventory.product-material.filtered')->middleware('permission:view-product-material');
        Route::get('/{id}/details', [ProductMaterialController::class, 'details'])->name('inventory.product-material.details')->middleware('permission:view-product-material');
        Route::get('/create', [ProductMaterialController::class, 'create'])->name('inventory.product-material.create')->middleware('permission:manage-product-material');
        Route::post('/create', [ProductMaterialController::class, 'store'])->name('inventory.product-material.store')->middleware('permission:manage-product-material');
        Route::get('/{id}/edit', [ProductMaterialController::class, 'edit'])->name('inventory.product-material.edit')->middleware('permission:manage-product-material');
        Route::post('/{id}/update', [ProductMaterialController::class, 'update'])->name('inventory.product-material.update')->middleware('permission:manage-product-material');
        Route::get('/{id}/purchase-history', [ProductMaterialController::class, 'purchaseHistory'])->name('inventory.product-material.purchase-history')->middleware('permission:view-product-material');
        Route::get('/{id}/delete', [ProductMaterialController::class, 'delete'])->name('inventory.product-material.delete')->middleware('permission:manage-product-material');
        Route::get('/{id}/change-status/{status}', [ProductMaterialController::class, 'statusUpdate'])->name('inventory.product-material.change-status')->middleware('permission:manage-product-material');
        Route::get('/get-sections-by-warehouse', [ProductMaterialController::class, 'getSectionsByWarehouse'])->name('inventory.product-material.get-sections-by-warehouse')->middleware('permission:manage-product-material');
        Route::get('/get-racks-by-sections', [ProductMaterialController::class, 'getRacksBySections'])->name('inventory.product-material.get-racks-by-sections')->middleware('permission:manage-product-material');

        Route::post('import/boards', [ProductMaterialController::class, 'importBoards'])->name('inventory.product-material.import-boards')->middleware('permission:manage-product-material');
        Route::post('import/papers', [ProductMaterialController::class, 'importPapers'])->name('inventory.product-material.import-papers')->middleware('permission:manage-product-material');
        Route::post('import/others', [ProductMaterialController::class, 'importOthers'])->name('inventory.product-material.import-others')->middleware('permission:manage-product-material');

        // calculate price 
        Route::get('/{id}/calculate-price', [ProductMaterialController::class, 'calculatePrice'])->name('inventory.product-material.calculate-price');
        Route::post('/{id}/calculate-price/store', [ProductMaterialController::class, 'calculatePriceStore'])->name('inventory.product-material.calculate-price.store');

        Route::get('add-to-cart', [ProductMaterialCartController::class, 'addToCart'])->name('inventory.product-material.add-to-cart');
        Route::get('get-cart-contents', [ProductMaterialCartController::class, 'getCartContents'])->name('inventory.product-material.get-cart-contents');
        Route::get('remove-cart-item', [ProductMaterialCartController::class, 'removeCartItem'])->name('inventory.product-material.remove-cart-item');
        Route::get('update-cart-qty', [ProductMaterialCartController::class, 'updateCartQty'])->name('inventory.product-material.update-cart-qty');

        Route::post('submit-cart', [ProductMaterialCartController::class, 'submitCart'])->name('inventory.product-material.submit-cart');
        
    });

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

    // product material sets
    Route::group(['prefix' => 'product-material-set'], function () {
        Route::get('/', [ProductMaterialSetController::class, 'index'])->name('inventory.product-material-set.index');
        Route::post('/filtered', [ProductMaterialSetController::class, 'indexFiltered'])->name('inventory.product-material-set.filtered');
        Route::get('/get-all-product-materials',[ProductMaterialSetController::class, 'getAllProductMaterials'])->name('inventory.product-material-set.get-all-product-materials');
        Route::get('/create', [ProductMaterialSetController::class, 'create'])->name('inventory.product-material-set.create');
        Route::post('/store', [ProductMaterialSetController::class, 'store'])->name('inventory.product-material-set.store');
        Route::get('/get-set-items/{id}',[ProductMaterialSetController::class, 'getSetItems'])->name('inventory.product-material-set.get-product-material-set-items');
        Route::get('/{id}/edit', [ProductMaterialSetController::class, 'edit'])->name('inventory.product-material-set.edit');
        Route::post('/{id}/update', [ProductMaterialSetController::class, 'update'])->name('inventory.product-material-set.update');
        Route::get('/{id}/delete', [ProductMaterialSetController::class, 'delete'])->name('inventory.product-material-set.delete');
        Route::get('/{id}/details', [ProductMaterialSetController::class, 'details'])->name('inventory.product-material-set.details');
    });

    Route::group(['prefix' => 'reuse-items'], function () {
        Route::get('/', [ReuseItemController::class, 'index'])->name('inventory.reuse-items.index');
        Route::post('/filtered', [ReuseItemController::class, 'indexFiltered'])->name('inventory.reuse-items.filtered');
        Route::get('/{id}/details', [ReuseItemController::class, 'details'])->name('inventory.reuse-items.details');
    });

    // dispatch invoice items
    Route::group(['prefix' => 'dispatch-invoice-items'], function () {
        Route::get('/',[DispatchInvoiceController::class,'index'])->name('inventory.dispatch-invoice-items.index')->middleware('permission:deliver-items');
        Route::post('/filtered',[DispatchInvoiceController::class,'indexFilteredData'])->name('inventory.dispatch-invoice-items.filtered')->middleware('permission:deliver-items');
        Route::get('/{id}/deliver', [DispatchInvoiceController::class, 'deliver'])->name('inventory.dispatch-invoice-items.deliver')->middleware('permission:deliver-items');
        Route::get('/{id}/get-deliver-data', [DispatchInvoiceController::class, 'getDeliverData'])->name('inventory.dispatch-invoice-items.get-deliver-data')->middleware('permission:deliver-items');
        Route::post('/{id}/deliver', [DispatchInvoiceController::class, 'deliverStore'])->name('inventory.dispatch-invoice-items.deliver.store')->middleware('permission:deliver-items');
    });
});
// inventory route end
