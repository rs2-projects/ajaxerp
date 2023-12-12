<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Settings\OfficeTimeSettingsController;
use App\Http\Controllers\Settings\OverTimeSettingsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['middleware' => 'guest'], function () {
    Route::get('login', [LoginController::class, 'showLogin'])->name('login');
    Route::post('login', [LoginController::class, 'login'])->name('login');
});

Route::group(['middleware' => 'auth'], function () {

    Route::get('logout', [LogoutController::class, 'logout'])->name('logout');

    // dashboard route start
    Route::get('/', [DashboardController::class, 'showDashboard'])->name('dashboard');
    Route::get('home', [DashboardController::class, 'showDashboard'])->name('home');
    // dashboard route end

    //setting route start
    Route::group(['prefix' => 'settings'], function () {
        Route::group(['prefix' => 'office-time'], function () {
            Route::get('/', [OfficeTimeSettingsController::class, 'showOfficeTimeSettings'])->name('settings.office-time');
            /*Route::post('/', [OfficeTimeSettingsController::class, 'saveOfficeTimeSettings'])->name('settings.office-time');*/
            Route::post('/create', [OfficeTimeSettingsController::class, 'storeOfficeTimeSettings'])->name('settings.office-time.store');
            Route::get('/{id}/edit', [OfficeTimeSettingsController::class, 'edit'])->name('settings.office-time.edit');
            Route::post('/{id}/update', [OfficeTimeSettingsController::class, 'update'])->name('settings.office-time.update');
            Route::get('/{id}/delete', [OfficeTimeSettingsController::class, 'delete'])->name('settings.office-time.delete');
        });

        // over time settings start
        Route::group(['prefix' => 'over-time'], function () {
            Route::get('/', [OverTimeSettingsController::class, 'showOverTimeSettings'])->name('settings.over-time');
            Route::post('/', [OverTimeSettingsController::class, 'filteredOverTimeSettings'])->name('settings.over-time');
            Route::post('/create', [OverTimeSettingsController::class, 'storeOverTimeSettings'])->name('settings.over-time-type.store');
            Route::get('/{id}/edit', [OverTimeSettingsController::class, 'edit'])->name('settings.over-time-type.edit');
            Route::post('/{id}/update', [OverTimeSettingsController::class, 'update'])->name('settings.over-time-type.update');
            Route::get('/{id}/delete', [OverTimeSettingsController::class, 'delete'])->name('settings.over-time-type.delete');
        });
    });
    //setting route end
});
