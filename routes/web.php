<?php

use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Hr\ContractorConroller;
use App\Http\Controllers\Hr\DepartmentController;
use App\Http\Controllers\Hr\DesignationController;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\UserLeavesController;
use App\Http\Controllers\Hr\SalarySetController;
use App\Http\Controllers\Hr\UserResignationController;
use App\Http\Controllers\Hr\UserTerminationController;
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
use App\Http\Controllers\Settings\TerminationTypeSettingsController;
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

    });
    // HR route end

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
    });
});
