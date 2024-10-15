<?php

use App\Http\Controllers\Production\Machine\MachineController;
use App\Http\Controllers\Production\PreProduction\PreProductionController;
use App\Http\Controllers\Inventory\PreProductionMaterialRequestController;
use App\Http\Controllers\Production\BoardPreProduction\BoardPreProductionController;
use App\Http\Controllers\Production\BoardPreProduction\CalculateBoardPriceController;
use App\Http\Controllers\Production\BoardProduction\BoardProductionController;
use App\Http\Controllers\Production\Production\ProductionController;
use App\Http\Controllers\Production\ProductionStaff\ProductionStaffController;
use Illuminate\Support\Facades\Route;

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
        Route::get('/', [BoardPreProductionController::class, 'index'])->name('production.board-pre-production.index')->middleware('permission:view-board-pre-productions');
        Route::post('/filtered', [BoardPreProductionController::class, 'indexFiltered'])->name('production.board-pre-production.filtered')->middleware('permission:view-board-pre-productions');
        Route::get('/create', [BoardPreProductionController::class, 'create'])->name('production.board-pre-production.create')->middleware('permission:manage-board-pre-productions');
        Route::get('get-material-by-category', [BoardPreProductionController::class, 'getMaterialByCategory'])->name('production.board-pre-production.get-material-products');
        Route::post('/create', [BoardPreProductionController::class, 'store'])->name('production.board-pre-production.store')->middleware('permission:manage-board-pre-productions');
        Route::get('/{id}/edit', [BoardPreProductionController::class, 'edit'])->name('production.board-pre-production.edit')->middleware('permission:manage-board-pre-productions');
        Route::post('/{id}/update', [BoardPreProductionController::class, 'update'])->name('production.board-pre-production.update')->middleware('permission:manage-board-pre-productions');
        Route::get('/{id}/delete', [BoardPreProductionController::class, 'delete'])->name('production.board-pre-production.delete')->middleware('permission:manage-board-pre-productions');
        Route::get('/{id}/get-details', [BoardPreProductionController::class, 'details'])->name('production.board-pre-production.get-production-details')->middleware('permission:view-board-pre-productions');
        Route::post('/{id}/send-to-production', [BoardPreProductionController::class, 'sendToProduction'])->name('production.board-pre-production.send-to-production')->middleware('permission:manage-board-pre-productions');
        
        // calculate price 
        Route::get('/{id}/calculate-price', [CalculateBoardPriceController::class, 'index'])->name('production.board-pre-production.calculate-price');
        Route::post('/{id}/calculate-price/store', [CalculateBoardPriceController::class, 'store'])->name('production.board-pre-production.calculate-price.store');

        
        // bulk import
        Route::post('bulk-import', [BoardPreProductionController::class, 'bulkImport'])->name('production.board-pre-production.bulk-import')->middleware('permission:manage-board-pre-productions');
    });

    Route::group(['prefix' => 'production-staff'], function () {
        Route::get('/', [ProductionStaffController::class, 'index'])->name('production.production-staff.index')->middleware('permission:view-production-staff');
        Route::post('/filtered', [ProductionStaffController::class, 'indexFiltered'])->name('production.production-staff.filtered')->middleware('permission:view-production-staff');
        Route::get('/create', [ProductionStaffController::class, 'create'])->name('production.production-staff.create')->middleware('permission:manage-production-staff');
        Route::post('/create', [ProductionStaffController::class, 'store'])->name('production.production-staff.store')->middleware('permission:manage-production-staff');
        Route::get('/{id}/edit', [ProductionStaffController::class, 'edit'])->name('production.production-staff.edit')->middleware('permission:manage-production-staff');
        Route::post('/{id}/update', [ProductionStaffController::class, 'update'])->name('production.production-staff.update')->middleware('permission:manage-production-staff');
        Route::get('/{id}/delete', [ProductionStaffController::class, 'delete'])->name('production.production-staff.delete')->middleware('permission:manage-production-staff');
        Route::get('/{id}/change-status/{status}', [ProductionStaffController::class, 'statusUpdate'])->name('production.production-staff.change-status')->middleware('permission:manage-production-staff');
    });
});

// board production
Route::group(['prefix' => 'board-production'], function () {
    Route::get('/', [BoardProductionController::class, 'index'])->name('production.board-production.index')->middleware('permission:view-board-production');
    Route::post('/filtered', [BoardProductionController::class, 'indexFiltered'])->name('production.board-production.filtered')->middleware('permission:view-board-production');
    Route::get('/{id}/get-document', [BoardProductionController::class, 'getDocument'])->name('production.board-production.get-design-document')->middleware('permission:view-board-production');
    Route::get('/{id}/details', [BoardProductionController::class, 'details'])->name('production.board-production.details')->middleware('permission:view-board-production');
    Route::get('/{id}/change/{processId}/process-status/{status}', [BoardProductionController::class, 'changeProcessStatus'])->name('production.board-production.update-process-status')->middleware('permission:view-board-production');
    Route::get('/{id}/receive', [BoardProductionController::class, 'receive'])->name('production.board-production.receive')->middleware('permission:receive-board-production-materials');
    Route::post('/{id}/receive', [BoardProductionController::class, 'receiveStore'])->name('production.board-production.receive.store')->middleware('permission:receive-board-production-materials');
    Route::get('/{id}/get-deliveries', [BoardProductionController::class, 'getDeliveries'])->name('production.board-production.get-delivery-details')->middleware('permission:receive-board-production-materials');
    Route::get('/{id}/check-barcode-validity', [BoardProductionController::class, 'checkBarCode'])->name('production.board-production.check-barcode')->middleware('permission:view-board-production');
    Route::get('/{id}/dispatch', [BoardProductionController::class, 'dispatch'])->name('production.board-production.dispatch-data')->middleware('permission:dispatch-board-production-materials');
    Route::post('/{id}/dispatch', [BoardProductionController::class, 'dispatchStore'])->name('production.board-production.dispatch.store')->middleware('permission:dispatch-board-production-materials');
    Route::get('/{id}/print-barcode/{type}', [BoardProductionController::class, 'printBarcode'])->name('production.board-production.print-barcode')->middleware('permission:production-board-print-barcode');

    // pending verification
    Route::get('pending-verification', [BoardProductionController::class, 'pendingVerification'])->name('production.board-production.pending-verification')->middleware('permission:verify-board-pre-productions');
    Route::post('pending-verification-data', [BoardProductionController::class, 'pendingVerificationData'])->name('production.board-production.pending-verification-data')->middleware('permission:verify-board-pre-productions');
    Route::get('/{id}/pending-verification/details', [BoardProductionController::class, 'pendingDetails'])->name('production.board-production.pending-verification-details')->middleware('permission:verify-board-pre-productions');
    Route::get('/{id}/change-status/{status}', [BoardProductionController::class, 'statusUpdate'])->name('production.board-production.pending-verification.change-status')->middleware('permission:verify-board-pre-productions');
    Route::get('/{id}/edit', [BoardProductionController::class, 'edit'])->name('production.board-production.edit')->middleware('permission:view-board-production');
    Route::post('/{id}/update', [BoardProductionController::class, 'update'])->name('production.board-production.update')->middleware('permission:view-board-production');
});

Route::group(['prefix' => 'material-request'], function () {
    Route::get('/', [PreProductionMaterialRequestController::class, 'index'])->name('inventory.material-request.index')->middleware('permission:view-material-requests');
    Route::post('/filtered', [PreProductionMaterialRequestController::class, 'indexFiltered'])->name('inventory.material-request.filtered')->middleware('permission:view-material-requests');
    Route::get('/{id}/details', [PreProductionMaterialRequestController::class, 'details'])->name('inventory.material-request.details')->middleware('permission:view-material-requests');
    Route::get('/{id}/deliver', [PreProductionMaterialRequestController::class, 'deliver'])->name('inventory.material-request.deliver')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/barcode-details', [PreProductionMaterialRequestController::class, 'barcodeDetails'])->name('inventory.material-request.barcode-details')->middleware('permission:deliver-requested-materials');
    Route::post('/{id}/deliver', [PreProductionMaterialRequestController::class, 'deliverStore'])->name('inventory.material-request.deliver.store')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/materials', [PreProductionMaterialRequestController::class, 'getMaterials'])->name('inventory.material-request.get-all-materials')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/deliver/{barcode}/{count}/{type}', [PreProductionMaterialRequestController::class, 'checkBarCode'])->name('inventory.material-request.check-barcode')->middleware('permission:deliver-requested-materials');
    Route::get('/{id}/get-document', [PreProductionMaterialRequestController::class, 'getDocument'])->name('inventory.material-request.get-design-document')->middleware('permission:view-material-requests');
});

Route::get('newer-picked-materials', [PreProductionMaterialRequestController::class, 'newerPickedMaterials'])->name('inventory.material-request.newer-picked-materials')->middleware('permission:view-material-requests');
