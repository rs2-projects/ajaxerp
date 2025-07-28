<?php

use App\Http\Controllers\Report\StockReport\AssetProductStockReportController;
use App\Http\Controllers\Report\StockReport\ProductMaterialStockReportController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'report'], function () {
    
    // product material stock report
    Route::group(['prefix' => 'product-material-stock-report'], function () {
        // Route::get('/', [ProductMaterialStockReportController::class, 'index'])->name('report.product-material-stock-report');
        // Route::post('/filtered', [ProductMaterialStockReportController::class, 'indexFiltered'])->name('report.product-material-stock-report.filtered');

        Route::get('/', [ProductMaterialStockReportController::class, 'index'])->name('report.product-material-stock-report');
        Route::post('/filtered', [ProductMaterialStockReportController::class, 'indexFiltered'])->name('report.product-material-stock-report.filtered');
    });

    // asset stock report
    Route::group(['prefix' => 'asset-product-stock-report'], function () {
        Route::get('/', [AssetProductStockReportController::class, 'index'])->name('report.asset-product-stock-report');
        Route::post('/filtered', [AssetProductStockReportController::class, 'indexFiltered'])->name('report.asset-product-stock-report.filtered');
    });
});