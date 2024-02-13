<?php

use App\Http\Controllers\Accounting\ChartOfAccountController;
use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\BotController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Hr\ContractorConroller;
use App\Http\Controllers\Hr\DepartmentController;
use App\Http\Controllers\Hr\DesignationController;
use App\Http\Controllers\Hr\EmployeeAttendanceController;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\SalarySetController;
use App\Http\Controllers\Hr\UserLeavesController;
use App\Http\Controllers\Hr\UserResignationController;
use App\Http\Controllers\Hr\UserTerminationController;
use App\Http\Controllers\Inventory\ProductMaterialCategoryController;
use App\Http\Controllers\Inventory\ProductMaterialController;
use App\Http\Controllers\Inventory\WarehouseController;
use App\Http\Controllers\Payroll\GeneratedSalaryController;
use App\Http\Controllers\Payroll\GenerateSalaryController;
use App\Http\Controllers\Procurement\ProductMaterial\ProductMaterialPurchaseController;
use App\Http\Controllers\Procurement\ProductMaterial\PurchaseInvestigationController;
use App\Http\Controllers\Procurement\ProductMaterial\PurchaseMakePaymentController;
use App\Http\Controllers\Settings\AbsentPenaltySettingsController;
use App\Http\Controllers\Settings\BonusTypeSalarySettingsController;
use App\Http\Controllers\Settings\BonusTypeSettingsController;
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
use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\LeavesController;
use App\Http\Controllers\User\ResignationController;
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

    //bot route start
    /*Route::get('chart-of-accounts', [BotController::class,'chartOfAccounts']);*/
    //bot route end

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

        // Termination Type settings start
        Route::group(['prefix' => 'termination-type'], function () {
            Route::get('/', [TerminationTypeSettingsController::class, 'index'])->name('settings.termination-type');
            Route::post('/filtered', [TerminationTypeSettingsController::class, 'indexFiltered'])->name('settings.termination-type.filtered');
            Route::post('/create', [TerminationTypeSettingsController::class, 'store'])->name('settings.termination-type.store');
            Route::get('/{id}/edit', [TerminationTypeSettingsController::class, 'edit'])->name('settings.termination-type.edit');
            Route::post('/{id}/update', [TerminationTypeSettingsController::class, 'update'])->name('settings.termination-type.update');
            Route::get('/{id}/delete', [TerminationTypeSettingsController::class, 'delete'])->name('settings.termination-type.delete');
            Route::get('/{id}/change-status/{status}', [TerminationTypeSettingsController::class, 'statusUpdate'])->name('settings.termination-type.change-status');
        });

        // Salary Deduction Type settings start
        Route::group(['prefix' => 'salary-deduction-type'], function () {
            Route::get('/', [SalaryDeductionTypeSettingsController::class, 'index'])->name('settings.salary-deduction-type');
            Route::post('/filtered', [SalaryDeductionTypeSettingsController::class, 'indexFiltered'])->name('settings.salary-deduction-type.filtered');
            Route::post('/create', [SalaryDeductionTypeSettingsController::class, 'store'])->name('settings.salary-deduction-type.store');
            Route::get('/{id}/edit', [SalaryDeductionTypeSettingsController::class, 'edit'])->name('settings.salary-deduction-type.edit');
            Route::post('/{id}/update', [SalaryDeductionTypeSettingsController::class, 'update'])->name('settings.salary-deduction-type.update');
            Route::get('/{id}/delete', [SalaryDeductionTypeSettingsController::class, 'delete'])->name('settings.salary-deduction-type.delete');
            Route::get('/{id}/change-status/{status}', [SalaryDeductionTypeSettingsController::class, 'statusUpdate'])->name('settings.salary-deduction-type.change-status');
        });

        // Vat Tax Type Settings start
        Route::group(['prefix' => 'vat-tax-type'], function () {
            Route::get('/', [VatTaxTypeSettingsController::class, 'index'])->name('settings.vat-tax-type.index');
            Route::post('/filtered', [VatTaxTypeSettingsController::class, 'indexFiltered'])->name('settings.vat-tax-type.filtered');
            Route::post('/create', [VatTaxTypeSettingsController::class, 'store'])->name('settings.vat-tax-type.store');
            Route::get('/{id}/edit', [VatTaxTypeSettingsController::class, 'edit'])->name('settings.vat-tax-type.edit');
            Route::post('/{id}/update', [VatTaxTypeSettingsController::class, 'update'])->name('settings.vat-tax-type.update');
            Route::get('/{id}/delete', [VatTaxTypeSettingsController::class, 'delete'])->name('settings.vat-tax-type.delete');
            Route::get('/{id}/change-status/{status}', [VatTaxTypeSettingsController::class, 'statusUpdate'])->name('settings.vat-tax-type.change-status');
        });

    });
    //setting route end

    // HR route start
    Route::group(['prefix' => 'hr'], function () {
       // department route start
        Route::group(['prefix' => 'department'], function () {
            Route::get('/', [DepartmentController::class, 'index'])->name('hr.department');
            Route::post('/filtered', [DepartmentController::class, 'indexFiltered'])->name('hr.department.filtered');
            Route::post('/create', [DepartmentController::class, 'store'])->name('hr.department.store');
            Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('hr.department.edit');
            Route::post('/{id}/update', [DepartmentController::class, 'update'])->name('hr.department.update');
            Route::get('/{id}/delete', [DepartmentController::class, 'delete'])->name('hr.department.delete');
            Route::get('/{id}/change-status/{status}', [DepartmentController::class, 'statusUpdate'])->name('hr.department.change-status');
        });
        // department route end
        Route::group(['prefix' => 'designation'], function () {
            Route::get('/', [DesignationController::class, 'index'])->name('hr.designation');
            Route::post('/filtered', [DesignationController::class, 'indexFiltered'])->name('hr.designation.filtered');
            Route::post('/create', [DesignationController::class, 'store'])->name('hr.designation.store');
            Route::get('/{id}/edit', [DesignationController::class, 'edit'])->name('hr.designation.edit');
            Route::post('/{id}/update', [DesignationController::class, 'update'])->name('hr.designation.update');
            Route::get('/{id}/delete', [DesignationController::class, 'delete'])->name('hr.designation.delete');
            Route::get('/{id}/change-status/{status}', [DesignationController::class, 'statusUpdate'])->name('hr.designation.change-status');
        });
        // designation route start

        // Employee route start
        Route::group(['prefix' => 'employee'], function () {
            Route::get('/', [EmployeeController::class, 'index'])->name('hr.employee');
            Route::post('/filtered', [EmployeeController::class, 'indexFiltered'])->name('hr.employee.filtered');
            Route::get('/create', [EmployeeController::class, 'create'])->name('hr.employee.create');
            Route::post('/create', [EmployeeController::class, 'store'])->name('hr.employee.store');
            Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('hr.employee.edit');
            Route::post('/{id}/update', [EmployeeController::class, 'update'])->name('hr.employee.update');
            Route::get('/{id}/delete', [EmployeeController::class, 'delete'])->name('hr.employee.delete');
            Route::get('/{id}/change-status/{status}', [EmployeeController::class, 'statusUpdate'])->name('hr.employee.change-status');
            Route::get('/{id}/details', [EmployeeController::class, 'details'])->name('hr.employee.details');
            Route::post('/{id}/details', [EmployeeController::class, 'detailFiltered'])->name('hr.employee.detail.filtered');
            Route::post('profile-info/{id}/update', [EmployeeController::class, 'profileInfoUpdate'])->name('hr.employee.profile-info.update');
            Route::post('personal-info/{id}/update', [EmployeeController::class, 'personalInfoUpdate'])->name('hr.employee.personal-info.update');
            Route::post('bank-info/{id}/update', [EmployeeController::class, 'bankInfoUpdate'])->name('hr.employee.bank-info.update');
            Route::post('education-info/{id}/update', [EmployeeController::class, 'educationInfoUpdate'])->name('hr.employee.education-info.update');
            Route::post('experience-info/{id}/update', [EmployeeController::class, 'experienceInfoUpdate'])->name('hr.employee.experience-info.update');
            Route::post('emergency-contact-info/{id}/update', [EmployeeController::class, 'emergencyContactInfoUpdate'])->name('hr.employee.emergency-contact-info.update');
        });
        // Employee route end

        // Salary set route start
        Route::group(['prefix' => 'salary-set'], function () {
            Route::get('/', [SalarySetController::class, 'index'])->name('hr.salary-set');
            Route::post('/filtered', [SalarySetController::class, 'indexFiltered'])->name('hr.salary-set.filtered');
            Route::get('/create', [SalarySetController::class, 'create'])->name('hr.salary-set.create');
            Route::post('/create', [SalarySetController::class, 'store'])->name('hr.salary-set.store');
            Route::get('/{id}/edit', [SalarySetController::class, 'edit'])->name('hr.salary-set.edit');
            Route::post('/{id}/update', [SalarySetController::class, 'update'])->name('hr.salary-set.update');
            Route::get('/{id}/delete', [SalarySetController::class, 'delete'])->name('hr.salary-set.delete');
            Route::get('/{id}/change-status/{status}', [SalarySetController::class, 'statusUpdate'])->name('hr.salary-set.change-status');

            Route::get('/attendance-set/{id}/edit',[SalarySetController::class, 'attendanceSetEdit'])->name('hr.salary-set.attendance-set.edit');
            Route::post('/attendance-set/{id}/update',[SalarySetController::class, 'attendanceSetUpdate'])->name('hr.salary-set.attendance-set.update');
            Route::get('/leave-type-set/{id}/edit',[SalarySetController::class, 'leaveTypeSetEdit'])->name('hr.salary-set.leave-type-set.edit');
            Route::post('/leave-type-set/{id}/update',[SalarySetController::class, 'leaveTypeSetUpdate'])->name('hr.salary-set.leave-type-set.update');
            Route::get('/{id}/set-employees',[SalarySetController::class, 'setEmployees'])->name('hr.salary-set.set-employees');
            Route::post('/{id}/set-employees',[SalarySetController::class, 'setEmployeesStore'])->name('hr.salary-set.set-employees.store');
        });
        // Salary set route end

        // User Leaves route start
        Route::group(['prefix' => 'user-leaves'], function () {
            Route::get('/', [UserLeavesController::class, 'index'])->name('hr.user-leaves');
            Route::post('/filtered', [UserLeavesController::class, 'indexFiltered'])->name('hr.user-leaves.filtered');
            Route::get('/create', [UserLeavesController::class, 'create'])->name('hr.user-leaves.create');
            Route::post('/create', [UserLeavesController::class, 'store'])->name('hr.user-leaves.store');
            Route::get('/{id}/edit', [UserLeavesController::class, 'edit'])->name('hr.user-leaves.edit');
            Route::post('/{id}/update', [UserLeavesController::class, 'update'])->name('hr.user-leaves.update');
            Route::get('/{id}/delete', [UserLeavesController::class, 'delete'])->name('hr.user-leaves.delete');
            Route::get('/{id}/change-status/{status}', [UserLeavesController::class, 'statusUpdate'])->name('hr.user-leaves.change-status');
            Route::get('/{id}/status-approve',[UserLeavesController::class, 'statusApprove'])->name('hr.user-leaves.status-approve');
            Route::post('/{id}/status-approve',[UserLeavesController::class, 'statusApproveUpdate'])->name('hr.user-leaves.status-approve');
            Route::get('/{id}/status-reject',[UserLeavesController::class, 'statusReject'])->name('hr.user-leaves.status-reject');
            Route::post('/{id}/status-reject',[UserLeavesController::class, 'statusRejectUpdate'])->name('hr.user-leaves.status-reject');
        });
        // User Leaves route end

        // User Resignation Route Start
        Route::group(['prefix' => 'user-resignation'], function () {
            Route::get('/', [UserResignationController::class, 'index'])->name('hr.user-resignation');
            Route::post('/filtered', [UserResignationController::class, 'indexFiltered'])->name('hr.user-resignation.filtered');
            Route::get('/create', [UserResignationController::class, 'create'])->name('hr.user-resignation.create');
            Route::post('/create', [UserResignationController::class, 'store'])->name('hr.user-resignation.store');
            Route::get('/{id}/edit', [UserResignationController::class, 'edit'])->name('hr.user-resignation.edit');
            Route::post('/{id}/update', [UserResignationController::class, 'update'])->name('hr.user-resignation.update');
            Route::get('/{id}/delete', [UserResignationController::class, 'delete'])->name('hr.user-resignation.delete');
            Route::get('/{id}/change-status/{status}', [UserResignationController::class, 'statusUpdate'])->name('hr.user-resignation.change-status');
            Route::get('/{id}/status-reject',[UserResignationController::class, 'statusReject'])->name('hr.user-resignation.status-reject');
            Route::post('/{id}/status-reject',[UserResignationController::class, 'statusRejectUpdate'])->name('hr.user-resignation.status-reject');
        });
        // User Resignation Route End

        // User Termination route start
        Route::group(['prefix' => 'user-termination'], function () {
            Route::get('/', [UserTerminationController::class, 'index'])->name('hr.user-termination');
            Route::post('/filtered', [UserTerminationController::class, 'indexFiltered'])->name('hr.user-termination.filtered');
            Route::get('/create', [UserTerminationController::class, 'create'])->name('hr.user-termination.create');
            Route::post('/create', [UserTerminationController::class, 'store'])->name('hr.user-termination.store');
            Route::get('/{id}/edit', [UserTerminationController::class, 'edit'])->name('hr.user-termination.edit');
            Route::post('/{id}/update', [UserTerminationController::class, 'update'])->name('hr.user-termination.update');
            Route::get('/{id}/delete', [UserTerminationController::class, 'delete'])->name('hr.user-termination.delete');
        });
        // User Termination route end

        // User Contractors Route Start
        Route::group(['prefix' => 'user-contractor'], function () {
            Route::get('/', [ContractorConroller::class, 'index'])->name('hr.user-contractor');
            Route::post('/filtered', [ContractorConroller::class, 'indexFiltered'])->name('hr.user-contractor.filtered');
            Route::get('/create', [ContractorConroller::class, 'create'])->name('hr.user-contractor.create');
            Route::post('/create', [ContractorConroller::class, 'store'])->name('hr.user-contractor.store');
            Route::get('/{id}/edit', [ContractorConroller::class, 'edit'])->name('hr.user-contractor.edit');
            Route::post('/{id}/update', [ContractorConroller::class, 'update'])->name('hr.user-contractor.update');
            Route::get('/{id}/delete', [ContractorConroller::class, 'delete'])->name('hr.user-contractor.delete');
        });
        // User Contractors Route End


        // common ajax route start
        Route::group(['prefix' => 'ajax'], function () {
            Route::get('get-designation-by-department', [AjaxController::class, 'getDesignationByDepartment'])->name('ajax.get-designation-by-department');
            Route::get('get-employees',[AjaxController::class,'getEmployees'])->name('ajax.get-employees');
            Route::get('salary-set/get-employees',[AjaxController::class,'salarySetGetEmployees'])->name('ajax.salary-set.get-employees');
            Route::get('get-leave-type-by-user',[AjaxController::class, 'getLeaveTypeByUser'])->name('ajax.get-leave-type-by-user');
            Route::get('get-employee-total-leave-by-leave-type',[AjaxController::class, 'getEmployeeTotalLeaveByLeaveType'])->name('ajax.get-user-total-leave-by-leave-type');
            Route::get('get-employee-total-leave-by-leave-type-edit',[AjaxController::class, 'getEmployeeTotalLeaveByLeaveTypeEdit'])->name('ajax.get-user-total-leave-by-leave-type-edit');
        });
        // common ajax route end

        // employee attendance route start
        Route::group(['prefix' => 'employee-attendance'], function () {
            Route::get('/', [EmployeeAttendanceController::class, 'index'])->name('hr.employee-attendance');
            Route::post('/filtered', [EmployeeAttendanceController::class, 'indexFiltered'])->name('hr.employee-attendance.filtered');
            Route::post('/bulk-attendance-store', [EmployeeAttendanceController::class, 'bulkAttendanceStore'])->name('hr.employee-attendance.bulk-attendance-store');
            Route::post('/attendance-store', [EmployeeAttendanceController::class, 'attendanceStore'])->name('hr.employee-attendance.attendance-store');
            Route::get('get-employees-by-attendance-date',[EmployeeAttendanceController::class, 'getEmployeesByAttendanceDate'])->name('hr.employee-attendance.get-employees-by-attendance-date');
            Route::post('get-employee-attendance-activity-details-by-date',[EmployeeAttendanceController::class, 'getEmployeeAttendanceActivityDetailsByDate'])->name('hr.employee-attendance.get-employee-attendance-activity-details-by-date');
            Route::post('get-employee-attendance-edit-details-by-date',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDate'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date');
            Route::post('get-employee-attendance-edit-details-by-date/edit-form',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDateEditForm'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date.edit-form');
            Route::post('get-employee-attendance-edit-details-by-date/{id}/update',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDateUpdate'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date.update');
        });
        // employee attendance route end

    });
    // HR route end

    //Payroll routes start
    Route::group(['prefix' => 'hr'], function () {

        // Generate Salary Route Start
        Route::group(['prefix' => 'generate-salary'], function () {
            Route::get('/', [GenerateSalaryController::class, 'index'])->name('payroll.generate-salary');
            Route::post('create', [GenerateSalaryController::class, 'create'])->name('payroll.generate-salary.create');
            Route::get('get-salary-generate-details',[GenerateSalaryController::class, 'getSalaryGenerateDetails'])->name('payroll.generate-salary.get-salary-generate-details');
            Route::get('get-salary-set-by-salary-type',[GenerateSalaryController::class, 'getSalarySetBySalaryType'])->name('payroll.generate-salary.get-salary-set-by-salary-type');
        });

        // generated Salary Route Start
        Route::group(['prefix' => 'generated-salary-list'], function () {
            Route::get('/', [GeneratedSalaryController::class, 'index'])->name('payroll.generated-salary');
            Route::post('/filtered', [GeneratedSalaryController::class, 'indexFiltered'])->name('payroll.generated-salary.filtered');
            Route::get('/{id}/details', [GeneratedSalaryController::class, 'details'])->name('payroll.generated-salary.details');
            Route::post('/{id}/details/filtered', [GeneratedSalaryController::class, 'detailsFiltered'])->name('payroll.generated-salary.details.filtered');
            Route::get('/details/{salary_details_id}/salary-details/edit', [GeneratedSalaryController::class, 'salaryDetailsEdit'])->name('payroll.generated-salary.details.salary-details.edit');
            Route::post('/details/{salary_details_id}/salary-details/update', [GeneratedSalaryController::class, 'salaryDetailsUpdate'])->name('payroll.generated-salary.details.salary-details.update');
            Route::get('/details/{salary_details_id}/salary-details/show', [GeneratedSalaryController::class, 'salaryDetailsShow'])->name('payroll.generated-salary.details.salary-details.show');

           /* Route::get('/{id}/edit', [GeneratedSalaryController::class, 'edit'])->name('payroll.generated-salary.edit');
            Route::post('/{id}/update', [GeneratedSalaryController::class, 'update'])->name('payroll.generated-salary.update');
            Route::get('/{id}/delete', [GeneratedSalaryController::class, 'delete'])->name('payroll.generated-salary.delete');*/
        });

    });
    //Payroll routes end

    // inventory route start
    Route::group(['prefix' => 'inventory'], function () {
        // warehouse route start
        Route::group(['prefix' => 'warehouse'], function () {
            Route::get('/', [WarehouseController::class, 'index'])->name('inventory.warehouse.index');
            Route::post('/filtered', [WarehouseController::class, 'indexFiltered'])->name('inventory.warehouse.filtered');
            Route::get('/create', [WarehouseController::class, 'create'])->name('inventory.warehouse.create');
            Route::post('/create', [WarehouseController::class, 'store'])->name('inventory.warehouse.store');
            Route::get('/{id}/edit', [WarehouseController::class, 'edit'])->name('inventory.warehouse.edit');
            Route::post('/{id}/update', [WarehouseController::class, 'update'])->name('inventory.warehouse.update');
            Route::get('/{id}/show', [WarehouseController::class, 'show'])->name('inventory.warehouse.show');
            Route::get('/{id}/delete', [WarehouseController::class, 'delete'])->name('inventory.warehouse.delete');
            Route::get('/{id}/change-status/{status}', [WarehouseController::class, 'statusUpdate'])->name('inventory.warehouse.change-status');
        });

        // product material category route start
        Route::group(['prefix' => 'product-material-category'], function () {
            Route::get('/', [ProductMaterialCategoryController::class, 'index'])->name('inventory.product-material-category.index');
            Route::post('/filtered', [ProductMaterialCategoryController::class, 'indexFiltered'])->name('inventory.product-material-category.filtered');
            Route::get('/create', [ProductMaterialCategoryController::class, 'create'])->name('inventory.product-material-category.create');
            Route::post('/create', [ProductMaterialCategoryController::class, 'store'])->name('inventory.product-material-category.store');
            Route::get('/{id}/edit', [ProductMaterialCategoryController::class, 'edit'])->name('inventory.product-material-category.edit');
            Route::post('/{id}/update', [ProductMaterialCategoryController::class, 'update'])->name('inventory.product-material-category.update');
            Route::get('/{id}/delete', [ProductMaterialCategoryController::class, 'delete'])->name('inventory.product-material-category.delete');
            Route::get('/{id}/change-status/{status}', [ProductMaterialCategoryController::class, 'statusUpdate'])->name('inventory.product-material-category.change-status');
        });

        // product material route start
        Route::group(['prefix' => 'product-material'], function () {
            Route::get('/', [ProductMaterialController::class, 'index'])->name('inventory.product-material.index');
            Route::post('/filtered', [ProductMaterialController::class, 'indexFiltered'])->name('inventory.product-material.filtered');
            Route::get('/create', [ProductMaterialController::class, 'create'])->name('inventory.product-material.create');
            Route::post('/create', [ProductMaterialController::class, 'store'])->name('inventory.product-material.store');
            Route::get('/{id}/edit', [ProductMaterialController::class, 'edit'])->name('inventory.product-material.edit');
            Route::post('/{id}/update', [ProductMaterialController::class, 'update'])->name('inventory.product-material.update');
            Route::get('/{id}/purchase-history', [ProductMaterialController::class, 'purchaseHistory'])->name('inventory.product-material.purchase-history');
            Route::get('/{id}/delete', [ProductMaterialController::class, 'delete'])->name('inventory.product-material.delete');
            Route::get('/{id}/change-status/{status}', [ProductMaterialController::class, 'statusUpdate'])->name('inventory.product-material.change-status');
            Route::get('/get-sections-by-warehouse', [ProductMaterialController::class, 'getSectionsByWarehouse'])->name('inventory.product-material.get-sections-by-warehouse');
            Route::get('/get-racks-by-sections', [ProductMaterialController::class, 'getRacksBySections'])->name('inventory.product-material.get-racks-by-sections');
        });
    });
    // inventory route end

    // Procurement route start
    Route::group(['prefix' => 'procurement'], function (){
       // product-material-purchase route start
        Route::group(['prefix' => 'product-material-purchase'], function () {
            Route::get('/', [ProductMaterialPurchaseController::class, 'index'])->name('procurement.product-material-purchase.index');
            Route::post('/filtered', [ProductMaterialPurchaseController::class, 'indexFiltered'])->name('procurement.product-material-purchase.filtered');
            Route::get('/create', [ProductMaterialPurchaseController::class, 'create'])->name('procurement.product-material-purchase.create');
            Route::post('/create', [ProductMaterialPurchaseController::class, 'store'])->name('procurement.product-material-purchase.store');
            Route::get('/{id}/edit', [ProductMaterialPurchaseController::class, 'edit'])->name('procurement.product-material-purchase.edit');
            Route::get('/{id}/edit-purchase-data-get', [ProductMaterialPurchaseController::class, 'getEditPurchaseData'])->name('procurement.product-material-purchase.get-edit-purchase-data');
            Route::post('/{id}/update', [ProductMaterialPurchaseController::class, 'update'])->name('procurement.product-material-purchase.update');
            Route::get('/{id}/delete', [ProductMaterialPurchaseController::class, 'delete'])->name('procurement.product-material-purchase.delete');
            Route::get('/{id}/change-status/{status}', [ProductMaterialPurchaseController::class, 'statusUpdate'])->name('procurement.product-material-purchase.change-status');

            // create and back purchase order
            Route::get('/{id}/create-revised-order', [ProductMaterialPurchaseController::class, 'createRevisedOrder'])->name('procurement.product-material-purchase.create-revised-order');
            Route::post('/{id}/create-revised-order', [ProductMaterialPurchaseController::class, 'storeRevisedOrder'])->name('procurement.product-material-purchase.store-revised-order');
            Route::get('/{id}/create-back-order', [ProductMaterialPurchaseController::class, 'createBackOrder'])->name('procurement.product-material-purchase.create-back-order');
            Route::post('/{id}/create-back-order', [ProductMaterialPurchaseController::class, 'storeBackOrder'])->name('procurement.product-material-purchase.store-back-order');

            Route::get('/get-all-product-materials',[ProductMaterialPurchaseController::class, 'getAllProductMaterials'])->name('procurement.product-material-purchase.get-all-product-materials');
            Route::get('/get-all-taxes',[ProductMaterialPurchaseController::class, 'getAllTaxes'])->name('procurement.product-material-purchase.get-all-taxes');
            Route::get('/get-all-suppliers',[ProductMaterialPurchaseController::class, 'getAllSuppliers'])->name('procurement.product-material-purchase.get-all-suppliers');

            // make payment
            Route::get('/{id}/make-payment', [PurchaseMakePaymentController::class, 'makePayment'])->name('procurement.product-material-purchase.make-payment');
            Route::post('/{id}/make-payment-submit', [PurchaseMakePaymentController::class, 'makePaymentSubmit'])->name('procurement.product-material-purchase.make-payment-submit');
        });
       // materials purchase order route end

        // purchase investigation route start
        Route::group(['prefix' => 'purchase-investigation'], function () {
            Route::get('/{purchase_id}', [PurchaseInvestigationController::class, 'index'])->name('procurement.purchase-investigation.index');
            Route::post('/{purchase_id}/update', [PurchaseInvestigationController::class, 'update'])->name('procurement.purchase-investigation.update');
        });
    });
    // Procurement route End


    // Accounting route start
    Route::group(['prefix' => 'accounting'], function (){

        // chart of accounts route start
        Route::group(['prefix' => 'chart-of-accounts'], function () {
            Route::get('/', [ChartOfAccountController::class, 'index'])->name('accounting.chart-of-accounts.index');
            Route::post('/filtered', [ChartOfAccountController::class, 'indexFiltered'])->name('accounting.chart-of-accounts.filtered');
            Route::get('/create', [ChartOfAccountController::class, 'create'])->name('accounting.chart-of-accounts.create');
            Route::post('/account-create', [ChartOfAccountController::class, 'accountStore'])->name('accounting.chart-of-accounts.account-store');
            Route::get('/{id}/edit', [ChartOfAccountController::class, 'accountEdit'])->name('accounting.chart-of-accounts.account-edit');
            Route::post('/{id}/update', [ChartOfAccountController::class, 'accountUpdate'])->name('accounting.chart-of-accounts.account-update');
            Route::get('/{id}/delete', [ChartOfAccountController::class, 'delete'])->name('accounting.chart-of-accounts.delete');
            Route::get('/{id}/change-status/{status}', [ChartOfAccountController::class, 'statusUpdate'])->name('accounting.chart-of-accounts.change-status');
        });
        // chart of accounts route end


    });
    // Accounting route end

    // User Resignation Route Start
    Route::group(['prefix' => 'user-resignation'], function () {
        Route::get('/', [ResignationController::class, 'index'])->name('user.resignation');
        Route::post('/filtered', [ResignationController::class, 'indexFiltered'])->name('user.resignation.filtered');
        Route::get('/create', [ResignationController::class, 'create'])->name('user.resignation.create');
        Route::post('/create', [ResignationController::class, 'store'])->name('user.resignation.store');
        Route::get('/{id}/edit', [ResignationController::class, 'edit'])->name('user.resignation.edit');
        Route::post('/{id}/update', [ResignationController::class, 'update'])->name('user.resignation.update');
        Route::get('/{id}/delete', [ResignationController::class, 'delete'])->name('user.resignation.delete');
        Route::get('/{id}/change-status/{status}', [ResignationController::class, 'statusUpdate'])->name('user.resignation.change-status');
    });
    // user leaves Route Start
    Route::group(['prefix' => 'user-leaves'], function () {
        Route::get('/', [LeavesController::class, 'index'])->name('user.leaves');
        Route::post('/filtered', [LeavesController::class, 'indexFiltered'])->name('user.leaves.filtered');
        Route::get('/create', [LeavesController::class, 'create'])->name('user.leaves.create');
        Route::post('/create', [LeavesController::class, 'store'])->name('user.leaves.store');
        Route::get('/{id}/edit', [LeavesController::class, 'edit'])->name('user.leaves.edit');
        Route::post('/{id}/update', [LeavesController::class, 'update'])->name('user.leaves.update');
        Route::get('/{id}/delete', [LeavesController::class, 'delete'])->name('user.leaves.delete');

        // ajax
        Route::get('get-user-leave-number-of-days',[LeavesController::class, 'getUserLeaveNumberOfDays'])->name('user.get-user-leave-number-of-days');
    });
    // user leaves Route End

    // user attendance Route Start
    Route::group(['prefix' => 'user-attendance'], function () {
        Route::get('/', [AttendanceController::class, 'index'])->name('user.attendance');
        Route::post('/filtered', [AttendanceController::class, 'indexFiltered'])->name('user.attendance.filtered');
        Route::get('/create', [AttendanceController::class, 'create'])->name('user.attendance.create');
        Route::post('/create', [AttendanceController::class, 'store'])->name('user.attendance.store');
        Route::get('/punch', [AttendanceController::class, 'punch'])->name('user.attendance.punch');
        Route::get('/{id}/edit', [AttendanceController::class, 'edit'])->name('user.attendance.edit');
        Route::post('/{id}/update', [AttendanceController::class, 'update'])->name('user.attendance.update');
        Route::get('/{id}/delete', [AttendanceController::class, 'delete'])->name('user.attendance.delete');
    });

    //include product materials route file
    include 'product_materials.php';
    //asset products
    include 'asset_product.php';
});
