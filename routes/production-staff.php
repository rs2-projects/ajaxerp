<?php

use App\Http\Controllers\ProductionStaff\DashboardController;
use App\Http\Controllers\ProductionStaff\LogoutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductionStaff\ProductionController;

Route::group(['middleware' => 'production_staff', 'prefix' => 'production-staff'], function () {

    // dashboard route start
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('production-staff.dashboard');

    // production routes start
    Route::group(['prefix' => 'production'], function () {
        Route::get('/', [ProductionController::class, 'index'])->name('production-staff.production.production.index');
        Route::post('/filtered', [ProductionController::class, 'indexFiltered'])->name('production-staff.production.production.filtered');
        Route::get('/{id}/get-document', [ProductionController::class, 'getDocument'])->name('production-staff.production.production.get-design-document');
        Route::get('/{id}/details', [ProductionController::class, 'details'])->name('production-staff.production.production.details');
        Route::get('/{id}/change/{processId}/process-status/{status}', [ProductionController::class, 'changeProcessStatus'])->name('production-staff.production.production.update-process-status');
        Route::get('/{id}/receive', [ProductionController::class, 'receive'])->name('production-staff.production.production.receive');
        Route::post('/{id}/receive', [ProductionController::class, 'receiveStore'])->name('production-staff.production.production.receive.store');
        Route::get('/{id}/get-deliveries', [ProductionController::class, 'getDeliveries'])->name('production-staff.production.production.get-delivery-details');
        Route::get('/{id}/check-barcode-validity', [ProductionController::class, 'checkBarCode'])->name('production-staff.production.production.check-barcode');
        Route::get('/{id}/dispatch', [ProductionController::class, 'dispatch'])->name('production-staff.production.production.dispatch-data');
        Route::post('/{id}/dispatch', [ProductionController::class, 'dispatchStore'])->name('production-staff.production.production.dispatch.store');
        Route::get('/{id}/print-barcode/{type}', [ProductionController::class, 'printBarcode'])->name('production-staff.production.production.print-barcode');
        Route::get('/{id}/verify-output/{process_id}', [ProductionController::class, 'verifyOutput'])->name('production-staff.production.production.verify-output-data');
        Route::get('/{id}/verify/{type}/update', [ProductionController::class, 'updateVerifyOutput'])->name('production-staff.production.production.verify-output.update');
        Route::get('get-material-by-category', [ProductionController::class, 'getMaterialByCategory'])->name('production-staff.production.production.get-material-by-category');
        Route::post('/re-recuisition/store', [ProductionController::class, 'reRecuisitionStore'])->name('production-staff.production.production.re-recuisition.store');

        // scan raw materials
        Route::get('/{id}/get-scan-deliveries', [ProductionController::class, 'getScanDeliveries'])->name('production-staff.production.production.get-delivery-details.scan');
        Route::get('/{id}/check-scan-barcode-validity', [ProductionController::class, 'checkScanBarCode'])->name('production-staff.production.production.check-barcode.scan');
        Route::post('/{id}/scan-store', [ProductionController::class, 'scanStore'])->name('production-staff.production.production.scan.store');
        
    });

    // logout 
    Route::get('logout', [LogoutController::class, 'logout'])->name('production-staff.logout');
});