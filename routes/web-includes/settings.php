<?php

use App\Http\Controllers\Settings\AbsentPenaltySettingsController;
use App\Http\Controllers\Settings\BonusTypeSalarySettingsController;
use App\Http\Controllers\Settings\BonusTypeSettingsController;
use App\Http\Controllers\Settings\CompanySettingsController;
use App\Http\Controllers\Settings\GeoLocationSettingsController;
use App\Http\Controllers\Settings\HolidaySettingsController;
use App\Http\Controllers\Settings\LatePenaltySettingsController;
use App\Http\Controllers\Settings\LeaveTypeSettingsController;
use App\Http\Controllers\Settings\OfficeTimeSettingsController;
use App\Http\Controllers\Settings\OverTimeSettingsController;
use App\Http\Controllers\Settings\SalaryDeductionTypeSettingsController;
use App\Http\Controllers\Settings\SalaryTypeSettingsController;
use App\Http\Controllers\Settings\TerminationTypeSettingsController;
use App\Http\Controllers\Settings\VatTaxTypeSettingsController;
use App\Http\Controllers\Settings\UserRoleController;
use App\Http\Controllers\Settings\UserRolePermissionController;
use App\Http\Controllers\Settings\BoardColorController;
use App\Http\Controllers\Settings\BoardEmbossedController;
use Illuminate\Support\Facades\Route;

//setting route start
Route::group(['prefix' => 'settings'], function () {
    // company settings route start
    Route::group(['prefix' => 'company', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [CompanySettingsController::class, 'edit'])->name('settings.company');
        Route::post('/update', [CompanySettingsController::class, 'update'])->name('settings.company.update');
    });
    // company settings route end

    // office time route start
    Route::group(['prefix' => 'office-time', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [OfficeTimeSettingsController::class, 'showOfficeTimeSettings'])->name('settings.office-time');
        Route::post('/filtered', [OfficeTimeSettingsController::class, 'filteredOfficeTimeSettings'])->name('settings.office-time.filtered');
        Route::post('/create', [OfficeTimeSettingsController::class, 'storeOfficeTimeSettings'])->name('settings.office-time.store');
        Route::get('/{id}/edit', [OfficeTimeSettingsController::class, 'edit'])->name('settings.office-time.edit');
        Route::post('/{id}/update', [OfficeTimeSettingsController::class, 'update'])->name('settings.office-time.update');
        Route::get('/{id}/delete', [OfficeTimeSettingsController::class, 'delete'])->name('settings.office-time.delete');
    });
    // office time route end

    // over time settings start
    Route::group(['prefix' => 'over-time', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [OverTimeSettingsController::class, 'showOverTimeSettings'])->name('settings.over-time');
        Route::post('/filtered', [OverTimeSettingsController::class, 'filteredOverTimeSettings'])->name('settings.over-time.filtered');
        Route::post('/create', [OverTimeSettingsController::class, 'storeOverTimeSettings'])->name('settings.over-time-type.store');
        Route::get('/{id}/edit', [OverTimeSettingsController::class, 'edit'])->name('settings.over-time-type.edit');
        Route::post('/{id}/update', [OverTimeSettingsController::class, 'update'])->name('settings.over-time-type.update');
        Route::get('/{id}/delete', [OverTimeSettingsController::class, 'delete'])->name('settings.over-time-type.delete');
    });

    // holidays settings start
    Route::group(['prefix' => 'holidays', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [HolidaySettingsController::class, 'index'])->name('settings.holidays');
        Route::post('/filtered', [HolidaySettingsController::class, 'indexFiltered'])->name('settings.holidays.filtered');
        Route::post('/create', [HolidaySettingsController::class, 'store'])->name('settings.holidays.store');
        Route::get('/{id}/edit', [HolidaySettingsController::class, 'edit'])->name('settings.holidays.edit');
        Route::post('/{id}/update', [HolidaySettingsController::class, 'update'])->name('settings.holidays.update');
        Route::get('/{id}/delete', [HolidaySettingsController::class, 'delete'])->name('settings.holidays.delete');
    });
    // holidays settings end

    // Leave Type settings start
    Route::group(['prefix' => 'leave-type', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [LeaveTypeSettingsController::class, 'index'])->name('settings.leave-type');
        Route::post('/filtered', [LeaveTypeSettingsController::class, 'indexFiltered'])->name('settings.leave-type.filtered');
        Route::post('/create', [LeaveTypeSettingsController::class, 'store'])->name('settings.leave-type.store');
        Route::get('/{id}/edit', [LeaveTypeSettingsController::class, 'edit'])->name('settings.leave-type.edit');
        Route::post('/{id}/update', [LeaveTypeSettingsController::class, 'update'])->name('settings.leave-type.update');
        Route::get('/{id}/delete', [LeaveTypeSettingsController::class, 'delete'])->name('settings.leave-type.delete');
        Route::get('/{id}/change-status/{status}', [LeaveTypeSettingsController::class, 'statusUpdate'])->name('settings.leave-type.change-status');
    });
    // Leave Type settings end

    // geo location settings start
    Route::group(['prefix' => 'geo-location', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [GeoLocationSettingsController::class, 'index'])->name('settings.geo-location');
        Route::post('/filtered', [GeoLocationSettingsController::class, 'indexFiltered'])->name('settings.geo-location.filtered');
        Route::post('/create', [GeoLocationSettingsController::class, 'store'])->name('settings.geo-location.store');
        Route::get('/{id}/edit', [GeoLocationSettingsController::class, 'edit'])->name('settings.geo-location.edit');
        Route::post('/{id}/update', [GeoLocationSettingsController::class, 'update'])->name('settings.geo-location.update');
        Route::get('/{id}/delete', [GeoLocationSettingsController::class, 'delete'])->name('settings.geo-location.delete');
        Route::get('/{id}/change-status/{status}', [GeoLocationSettingsController::class, 'statusUpdate'])->name('settings.geo-location.change-status');
    });
    // geo location settings end

    // Termination Type settings start
    Route::group(['prefix' => 'termination-type', 'middleware' => 'permission:manage-administration-settings'], function () {
        Route::get('/', [TerminationTypeSettingsController::class, 'index'])->name('settings.termination-type');
        Route::post('/filtered', [TerminationTypeSettingsController::class, 'indexFiltered'])->name('settings.termination-type.filtered');
        Route::post('/create', [TerminationTypeSettingsController::class, 'store'])->name('settings.termination-type.store');
        Route::get('/{id}/edit', [TerminationTypeSettingsController::class, 'edit'])->name('settings.termination-type.edit');
        Route::post('/{id}/update', [TerminationTypeSettingsController::class, 'update'])->name('settings.termination-type.update');
        Route::get('/{id}/delete', [TerminationTypeSettingsController::class, 'delete'])->name('settings.termination-type.delete');
        Route::get('/{id}/change-status/{status}', [TerminationTypeSettingsController::class, 'statusUpdate'])->name('settings.termination-type.change-status');
    });

    // bonus type settings start
    Route::group(['prefix' => 'bonus-type', 'middleware' => 'permission:manage-payroll-settings'], function () {
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
    Route::group(['prefix' => 'bonus-type-salary', 'middleware' => 'permission:manage-payroll-settings'], function () {
        Route::get('/', [BonusTypeSalarySettingsController::class, 'index'])->name('settings.bonus-type-salary');
        Route::post('/filtered', [BonusTypeSalarySettingsController::class, 'indexFiltered'])->name('settings.bonus-type-salary.filtered');
        Route::post('/create', [BonusTypeSalarySettingsController::class, 'store'])->name('settings.bonus-type-salary.store');
        Route::get('/{id}/edit', [BonusTypeSalarySettingsController::class, 'edit'])->name('settings.bonus-type-salary.edit');
        Route::post('/{id}/update', [BonusTypeSalarySettingsController::class, 'update'])->name('settings.bonus-type-salary.update');
        Route::get('/{id}/delete', [BonusTypeSalarySettingsController::class, 'delete'])->name('settings.bonus-type-salary.delete');
        Route::get('/{id}/change-status/{status}', [BonusTypeSalarySettingsController::class, 'statusUpdate'])->name('settings.bonus-type-salary.change-status');
    });
    // bonus-type-salary settings end

    // salary type settings start
    Route::group(['prefix' => 'salary-type', 'middleware' => 'permission:manage-payroll-settings'], function () {
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
    Route::group(['prefix' => 'absent-penalty', 'middleware' => 'permission:manage-payroll-settings'], function () {
        Route::get('/', [AbsentPenaltySettingsController::class, 'index'])->name('settings.absent-penalty');
        Route::post('/filtered', [AbsentPenaltySettingsController::class, 'indexFiltered'])->name('settings.absent-penalty.filtered');
        Route::post('/create', [AbsentPenaltySettingsController::class, 'store'])->name('settings.absent-penalty.store');
        Route::get('/{id}/edit', [AbsentPenaltySettingsController::class, 'edit'])->name('settings.absent-penalty.edit');
        Route::post('/{id}/update', [AbsentPenaltySettingsController::class, 'update'])->name('settings.absent-penalty.update');
        Route::get('/{id}/delete', [AbsentPenaltySettingsController::class, 'delete'])->name('settings.absent-penalty.delete');
    });
    // absent penalty settings end

    // late penalty settings start
    Route::group(['prefix' => 'late-penalty', 'middleware' => 'permission:manage-payroll-settings'], function () {
        Route::get('/', [LatePenaltySettingsController::class, 'index'])->name('settings.late-penalty');
        Route::post('/filtered', [LatePenaltySettingsController::class, 'indexFiltered'])->name('settings.late-penalty.filtered');
        Route::post('/create', [LatePenaltySettingsController::class, 'store'])->name('settings.late-penalty.store');
        Route::get('/{id}/edit', [LatePenaltySettingsController::class, 'edit'])->name('settings.late-penalty.edit');
        Route::post('/{id}/update', [LatePenaltySettingsController::class, 'update'])->name('settings.late-penalty.update');
        Route::get('/{id}/delete', [LatePenaltySettingsController::class, 'delete'])->name('settings.late-penalty.delete');
    });
    // late penalty settings end

    // Salary Deduction Type settings start
    Route::group(['prefix' => 'salary-deduction-type', 'middleware' => 'permission:manage-payroll-settings'], function () {
        Route::get('/', [SalaryDeductionTypeSettingsController::class, 'index'])->name('settings.salary-deduction-type');
        Route::post('/filtered', [SalaryDeductionTypeSettingsController::class, 'indexFiltered'])->name('settings.salary-deduction-type.filtered');
        Route::post('/create', [SalaryDeductionTypeSettingsController::class, 'store'])->name('settings.salary-deduction-type.store');
        Route::get('/{id}/edit', [SalaryDeductionTypeSettingsController::class, 'edit'])->name('settings.salary-deduction-type.edit');
        Route::post('/{id}/update', [SalaryDeductionTypeSettingsController::class, 'update'])->name('settings.salary-deduction-type.update');
        Route::get('/{id}/delete', [SalaryDeductionTypeSettingsController::class, 'delete'])->name('settings.salary-deduction-type.delete');
        Route::get('/{id}/change-status/{status}', [SalaryDeductionTypeSettingsController::class, 'statusUpdate'])->name('settings.salary-deduction-type.change-status');
    });

    // Vat Tax Type Settings start
    Route::group(['prefix' => 'vat-tax-type', 'middleware' => 'permission:manage-tax-settings'], function () {
        Route::get('/', [VatTaxTypeSettingsController::class, 'index'])->name('settings.vat-tax-type.index');
        Route::post('/filtered', [VatTaxTypeSettingsController::class, 'indexFiltered'])->name('settings.vat-tax-type.filtered');
        Route::post('/create', [VatTaxTypeSettingsController::class, 'store'])->name('settings.vat-tax-type.store');
        Route::get('/{id}/edit', [VatTaxTypeSettingsController::class, 'edit'])->name('settings.vat-tax-type.edit');
        Route::post('/{id}/update', [VatTaxTypeSettingsController::class, 'update'])->name('settings.vat-tax-type.update');
        Route::get('/{id}/delete', [VatTaxTypeSettingsController::class, 'delete'])->name('settings.vat-tax-type.delete');
        Route::get('/{id}/change-status/{status}', [VatTaxTypeSettingsController::class, 'statusUpdate'])->name('settings.vat-tax-type.change-status');
    });

    //role management
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
        Route::get('/', [BoardEmbossedController::class, 'index'])->name('settings.board-embossed.index')->middleware('permission:view-plate');
        Route::post('/filtered', [BoardEmbossedController::class, 'indexFiltered'])->name('settings.board-embossed.filtered')->middleware('permission:view-plate');
        Route::post('/create', [BoardEmbossedController::class, 'store'])->name('settings.board-embossed.store')->middleware('permission:manage-plate');
        Route::get('/{id}/edit', [BoardEmbossedController::class, 'edit'])->name('settings.board-embossed.edit')->middleware('permission:manage-plate');
        Route::post('/{id}/update', [BoardEmbossedController::class, 'update'])->name('settings.board-embossed.update')->middleware('permission:manage-plate');
        Route::get('/{id}/delete', [BoardEmbossedController::class, 'delete'])->name('settings.board-embossed.delete')->middleware('permission:manage-plate');

        Route::post('bulk-import', [BoardEmbossedController::class, 'importPlates'])->name('settings.board-embossed.bulk-import')->middleware('permission:manage-plate');
    });
    // board embossed route end
});
//setting route end
