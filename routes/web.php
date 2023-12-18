<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Settings\AbsentPenaltySettingsController;
use App\Http\Controllers\Settings\BonusTypeSalarySettingsController;
use App\Http\Controllers\Settings\BonusTypeSettingsController;
use App\Http\Controllers\Settings\GeoLocationSettingsController;
use App\Http\Controllers\Settings\HolidaySettingsController;
use App\Http\Controllers\Settings\LatePenaltySettingsController;
use App\Http\Controllers\Settings\LeaveTypeSettingsController;
use App\Http\Controllers\Settings\OfficeTimeSettingsController;
use App\Http\Controllers\Settings\OverTimeSettingsController;
use App\Http\Controllers\Settings\SalaryTypeSettingsController;
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
            Route::post('/filtered', [OfficeTimeSettingsController::class, 'filteredOfficeTimeSettings'])->name('settings.office-time.filtered');
            Route::post('/create', [OfficeTimeSettingsController::class, 'storeOfficeTimeSettings'])->name('settings.office-time.store');
            Route::get('/{id}/edit', [OfficeTimeSettingsController::class, 'edit'])->name('settings.office-time.edit');
            Route::post('/{id}/update', [OfficeTimeSettingsController::class, 'update'])->name('settings.office-time.update');
            Route::get('/{id}/delete', [OfficeTimeSettingsController::class, 'delete'])->name('settings.office-time.delete');
        });

        // over time settings start
        Route::group(['prefix' => 'over-time'], function () {
            Route::get('/', [OverTimeSettingsController::class, 'showOverTimeSettings'])->name('settings.over-time');
            Route::post('/filtered', [OverTimeSettingsController::class, 'filteredOverTimeSettings'])->name('settings.over-time.filtered');
            Route::post('/create', [OverTimeSettingsController::class, 'storeOverTimeSettings'])->name('settings.over-time-type.store');
            Route::get('/{id}/edit', [OverTimeSettingsController::class, 'edit'])->name('settings.over-time-type.edit');
            Route::post('/{id}/update', [OverTimeSettingsController::class, 'update'])->name('settings.over-time-type.update');
            Route::get('/{id}/delete', [OverTimeSettingsController::class, 'delete'])->name('settings.over-time-type.delete');
        });

        // holidays settings start
        Route::group(['prefix' => 'holidays'], function () {
            Route::get('/', [HolidaySettingsController::class, 'index'])->name('settings.holidays');
            Route::post('/filtered', [HolidaySettingsController::class, 'indexFiltered'])->name('settings.holidays.filtered');
            Route::post('/create', [HolidaySettingsController::class, 'store'])->name('settings.holidays.store');
            Route::get('/{id}/edit', [HolidaySettingsController::class, 'edit'])->name('settings.holidays.edit');
            Route::post('/{id}/update', [HolidaySettingsController::class, 'update'])->name('settings.holidays.update');
            Route::get('/{id}/delete', [HolidaySettingsController::class, 'delete'])->name('settings.holidays.delete');
        });
        // holidays settings end

        // Leave Type settings start
        Route::group(['prefix' => 'leave-type'], function () {
            Route::get('/', [LeaveTypeSettingsController::class, 'index'])->name('settings.leave-type');
            Route::post('/filtered', [LeaveTypeSettingsController::class, 'indexFiltered'])->name('settings.leave-type.filtered');
            Route::post('/create', [LeaveTypeSettingsController::class, 'store'])->name('settings.leave-type.store');
            Route::get('/{id}/edit', [LeaveTypeSettingsController::class, 'edit'])->name('settings.leave-type.edit');
            Route::post('/{id}/update', [LeaveTypeSettingsController::class, 'update'])->name('settings.leave-type.update');
            Route::get('/{id}/delete', [LeaveTypeSettingsController::class, 'delete'])->name('settings.leave-type.delete');
            Route::get('/{id}/change-status/{status}', [LeaveTypeSettingsController::class, 'statusUpdate'])->name('settings.leave-type.change-status');
        });
        // Leave Type settings end

        // bonus type settings start
        Route::group(['prefix' => 'bonus-type'], function () {
            Route::get('/', [BonusTypeSettingsController::class, 'index'])->name('settings.bonus-type');
            Route::post('/filtered', [BonusTypeSettingsController::class, 'indexFiltered'])->name('settings.bonus-type.filtered');
            Route::post('/create', [BonusTypeSettingsController::class, 'store'])->name('settings.bonus-type.store');
            Route::get('/{id}/edit', [BonusTypeSettingsController::class, 'edit'])->name('settings.bonus-type.edit');
            Route::post('/{id}/update', [BonusTypeSettingsController::class, 'update'])->name('settings.bonus-type.update');
            Route::get('/{id}/delete', [BonusTypeSettingsController::class, 'delete'])->name('settings.bonus-type.delete');
            Route::get('/{id}/change-status/{status}', [BonusTypeSettingsController::class, 'statusUpdate'])->name('settings.bonus-type.change-status');
        });
        // bonus type settings end

        // bonus-type-salary settings start
        Route::group(['prefix' => 'bonus-type-salary'], function () {
            Route::get('/', [BonusTypeSalarySettingsController::class, 'index'])->name('settings.bonus-type-salary');
            Route::post('/filtered', [BonusTypeSalarySettingsController::class, 'indexFiltered'])->name('settings.bonus-type-salary.filtered');
            Route::post('/create', [BonusTypeSalarySettingsController::class, 'store'])->name('settings.bonus-type-salary.store');
            Route::get('/{id}/edit', [BonusTypeSalarySettingsController::class, 'edit'])->name('settings.bonus-type-salary.edit');
            Route::post('/{id}/update', [BonusTypeSalarySettingsController::class, 'update'])->name('settings.bonus-type-salary.update');
            Route::get('/{id}/delete', [BonusTypeSalarySettingsController::class, 'delete'])->name('settings.bonus-type-salary.delete');
            Route::get('/{id}/change-status/{status}', [BonusTypeSalarySettingsController::class, 'statusUpdate'])->name('settings.bonus-type-salary.change-status');
        });
        // bonus-type-salary settings end

        // geo location settings start
        Route::group(['prefix' => 'geo-location'], function () {
            Route::get('/', [GeoLocationSettingsController::class, 'index'])->name('settings.geo-location');
            Route::post('/filtered', [GeoLocationSettingsController::class, 'indexFiltered'])->name('settings.geo-location.filtered');
            Route::post('/create', [GeoLocationSettingsController::class, 'store'])->name('settings.geo-location.store');
            Route::get('/{id}/edit', [GeoLocationSettingsController::class, 'edit'])->name('settings.geo-location.edit');
            Route::post('/{id}/update', [GeoLocationSettingsController::class, 'update'])->name('settings.geo-location.update');
            Route::get('/{id}/delete', [GeoLocationSettingsController::class, 'delete'])->name('settings.geo-location.delete');
            Route::get('/{id}/change-status/{status}', [GeoLocationSettingsController::class, 'statusUpdate'])->name('settings.geo-location.change-status');
        });
        // geo location settings end

        // salary type settings start
        Route::group(['prefix' => 'salary-type'], function () {
            Route::get('/', [SalaryTypeSettingsController::class, 'index'])->name('settings.salary-type');
            Route::post('/filtered', [SalaryTypeSettingsController::class, 'indexFiltered'])->name('settings.salary-type.filtered');
            Route::get('/create', [SalaryTypeSettingsController::class, 'create'])->name('settings.salary-type.create');
            Route::post('/create', [SalaryTypeSettingsController::class, 'store'])->name('settings.salary-type.store');
            Route::get('/{id}/edit', [SalaryTypeSettingsController::class, 'edit'])->name('settings.salary-type.edit');
            Route::post('/{id}/update', [SalaryTypeSettingsController::class, 'update'])->name('settings.salary-type.update');
            Route::get('/{id}/delete', [SalaryTypeSettingsController::class, 'delete'])->name('settings.salary-type.delete');
            Route::get('/{id}/change-status/{status}', [SalaryTypeSettingsController::class, 'statusUpdate'])->name('settings.salary-type.change-status');
        });
        // salary type settings end

        // absent penalty settings start
        Route::group(['prefix' => 'absent-penalty'], function () {
            Route::get('/', [AbsentPenaltySettingsController::class, 'index'])->name('settings.absent-penalty');
            Route::post('/filtered', [AbsentPenaltySettingsController::class, 'indexFiltered'])->name('settings.absent-penalty.filtered');
            Route::post('/create', [AbsentPenaltySettingsController::class, 'store'])->name('settings.absent-penalty.store');
            Route::get('/{id}/edit', [AbsentPenaltySettingsController::class, 'edit'])->name('settings.absent-penalty.edit');
            Route::post('/{id}/update', [AbsentPenaltySettingsController::class, 'update'])->name('settings.absent-penalty.update');
            Route::get('/{id}/delete', [AbsentPenaltySettingsController::class, 'delete'])->name('settings.absent-penalty.delete');
        });
        // absent penalty settings end

        // late penalty settings start
        Route::group(['prefix' => 'late-penalty'], function () {
            Route::get('/', [LatePenaltySettingsController::class, 'index'])->name('settings.late-penalty');
            Route::post('/filtered', [LatePenaltySettingsController::class, 'indexFiltered'])->name('settings.late-penalty.filtered');
            Route::post('/create', [LatePenaltySettingsController::class, 'store'])->name('settings.late-penalty.store');
            Route::get('/{id}/edit', [LatePenaltySettingsController::class, 'edit'])->name('settings.late-penalty.edit');
            Route::post('/{id}/update', [LatePenaltySettingsController::class, 'update'])->name('settings.late-penalty.update');
            Route::get('/{id}/delete', [LatePenaltySettingsController::class, 'delete'])->name('settings.late-penalty.delete');
        });
        // late penalty settings end


    });
    //setting route end
});
