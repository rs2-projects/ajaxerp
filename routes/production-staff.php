<?php

use App\Http\Controllers\ProductionStaff\DashboardController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'production_staff', 'prefix' => 'production-staff'], function () {

    // dashboard route start
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('production-staff.dashboard');
});