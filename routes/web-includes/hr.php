<?php

use App\Http\Controllers\Ajax\AjaxController;
use App\Http\Controllers\Hr\ContractorConroller;
use App\Http\Controllers\Hr\DepartmentController;
use App\Http\Controllers\Hr\DesignationController;
use App\Http\Controllers\Hr\EmployeeAttendanceController;
use App\Http\Controllers\Hr\EmployeeController;
use App\Http\Controllers\Hr\EmployeeLoginController;
use App\Http\Controllers\Hr\EmployeePromotionController;
use App\Http\Controllers\Hr\SalarySetController;
use App\Http\Controllers\Hr\UserLeavesController;
use App\Http\Controllers\Hr\UserResignationController;
use App\Http\Controllers\Hr\UserTerminationController;
use App\Http\Controllers\Payroll\GeneratedSalaryController;
use App\Http\Controllers\Payroll\GenerateSalaryController;
use Illuminate\Support\Facades\Route;

// HR route start
Route::group(['prefix' => 'hr'], function () {
    // department route start
    Route::group(['prefix' => 'department'], function () {
        Route::get('/', [DepartmentController::class, 'index'])->name('hr.department')->middleware('permission:view-departments');
        Route::post('/filtered', [DepartmentController::class, 'indexFiltered'])->name('hr.department.filtered')->middleware('permission:view-departments');
        Route::post('/create', [DepartmentController::class, 'store'])->name('hr.department.store')->middleware('permission:manage-departments');
        Route::get('/{id}/edit', [DepartmentController::class, 'edit'])->name('hr.department.edit')->middleware('permission:manage-departments');
        Route::post('/{id}/update', [DepartmentController::class, 'update'])->name('hr.department.update')->middleware('permission:manage-departments');
        Route::get('/{id}/delete', [DepartmentController::class, 'delete'])->name('hr.department.delete')->middleware('permission:manage-departments');
        Route::get('/{id}/change-status/{status}', [DepartmentController::class, 'statusUpdate'])->name('hr.department.change-status')->middleware('permission:manage-departments');
    });
    // department route end
    Route::group(['prefix' => 'designation'], function () {
        Route::get('/', [DesignationController::class, 'index'])->name('hr.designation')->middleware('permission:view-designations');
        Route::post('/filtered', [DesignationController::class, 'indexFiltered'])->name('hr.designation.filtered')->middleware('permission:view-designations');
        Route::post('/create', [DesignationController::class, 'store'])->name('hr.designation.store')->middleware('permission:manage-designations');
        Route::get('/{id}/edit', [DesignationController::class, 'edit'])->name('hr.designation.edit')->middleware('permission:manage-designations');
        Route::post('/{id}/update', [DesignationController::class, 'update'])->name('hr.designation.update')->middleware('permission:manage-designations');
        Route::get('/{id}/delete', [DesignationController::class, 'delete'])->name('hr.designation.delete')->middleware('permission:manage-designations');
        Route::get('/{id}/change-status/{status}', [DesignationController::class, 'statusUpdate'])->name('hr.designation.change-status')->middleware('permission:manage-designations');
    });
    // designation route start

    // Employee route start
    Route::group(['prefix' => 'employee'], function () {
        Route::get('/', [EmployeeController::class, 'index'])->name('hr.employee')->middleware('permission:view-employees');
        Route::post('/filtered', [EmployeeController::class, 'indexFiltered'])->name('hr.employee.filtered')->middleware('permission:view-employees');
        Route::get('/create', [EmployeeController::class, 'create'])->name('hr.employee.create')->middleware('permission:manage-employees');
        Route::post('/create', [EmployeeController::class, 'store'])->name('hr.employee.store')->middleware('permission:manage-employees');
        Route::get('/{id}/edit', [EmployeeController::class, 'edit'])->name('hr.employee.edit')->middleware('permission:manage-employees');
        Route::post('/{id}/update', [EmployeeController::class, 'update'])->name('hr.employee.update')->middleware('permission:manage-employees');
        Route::get('/{id}/delete', [EmployeeController::class, 'delete'])->name('hr.employee.delete')->middleware('permission:manage-employees');
        Route::get('/{id}/change-status/{status}', [EmployeeController::class, 'statusUpdate'])->name('hr.employee.change-status')->middleware('permission:manage-employees');
        Route::get('/{id}/details', [EmployeeController::class, 'details'])->name('hr.employee.details')->middleware('permission:view-employees');
        Route::post('/{id}/details', [EmployeeController::class, 'detailFiltered'])->name('hr.employee.detail.filtered')->middleware('permission:view-employees');
        Route::post('profile-info/{id}/update', [EmployeeController::class, 'profileInfoUpdate'])->name('hr.employee.profile-info.update')->middleware('permission:manage-employees');
        Route::post('personal-info/{id}/update', [EmployeeController::class, 'personalInfoUpdate'])->name('hr.employee.personal-info.update')->middleware('permission:manage-employees');
        Route::post('bank-info/{id}/update', [EmployeeController::class, 'bankInfoUpdate'])->name('hr.employee.bank-info.update')->middleware('permission:manage-employees');
        Route::post('education-info/{id}/update', [EmployeeController::class, 'educationInfoUpdate'])->name('hr.employee.education-info.update')->middleware('permission:manage-employees');
        Route::post('experience-info/{id}/update', [EmployeeController::class, 'experienceInfoUpdate'])->name('hr.employee.experience-info.update')->middleware('permission:manage-employees');
        Route::post('emergency-contact-info/{id}/update', [EmployeeController::class, 'emergencyContactInfoUpdate'])->name('hr.employee.emergency-contact-info.update')->middleware('permission:manage-employees');
        Route::get('/{id}/edit-role', [EmployeeController::class, 'changeRole'])->name('hr.employee.edit-role')->middleware('permission:manage-employees');
        Route::post('/{id}/update-role', [EmployeeController::class, 'updateRole'])->name('hr.employee.update-role')->middleware('permission:manage-employees');
        Route::post('{id}/update-password', [EmployeeController::class, 'updatePassword'])->name('hr.employee.update-password')->middleware('permission:manage-employees');

        // employee leave
        Route::get('get-user-leave-number-of-days',[EmployeeController::class, 'getUserLeaveNumberOfDays'])->name('hr.employee.get-user-leave-number-of-days');
        Route::post('/employee-leave/create', [EmployeeController::class, 'storeEmpLeave'])->name('hr.employee-leaves.store');

        // employee promotion
        Route::get('{id}/get-promotion-modal-data',[EmployeePromotionController::class, 'getPromotionModalData'])->name('hr.employee.get-promotion-modal-data');
        Route::post('{id}/promote', [EmployeePromotionController::class, 'storeEmployeePromotion'])->name('hr.employee.store-promotion');
        Route::get('{id}/get-demotion-modal-data',[EmployeePromotionController::class, 'getDemotionModalData'])->name('hr.employee.get-demotion-modal-data');
        Route::post('{id}/demote', [EmployeePromotionController::class, 'storeEmployeeDemotion'])->name('hr.employee.store-demotion');
        Route::get('{id}/get-update-salary-modal-data',[EmployeePromotionController::class, 'getUpdateSalaryModalData'])->name('hr.employee.get-update-salary-modal-data');
        Route::post('{id}/update-salary', [EmployeePromotionController::class, 'storeEmployeeUpdateSalary'])->name('hr.employee.store-update-salary');

        // employee panel login
        Route::get('/{id}/login', [EmployeeLoginController::class, 'login'])->name('hr.employee.login');
        Route::get('login/back-to-admin', [EmployeeLoginController::class, 'backToAdmin'])->name('hr.employee.login.back-to-admin');
    });
    // Employee route end

    // Salary set route start
    Route::group(['prefix' => 'salary-set'], function () {
        Route::get('/', [SalarySetController::class, 'index'])->name('hr.salary-set')->middleware('permission:view-salary-set');
        Route::post('/filtered', [SalarySetController::class, 'indexFiltered'])->name('hr.salary-set.filtered')->middleware('permission:view-salary-set');
        Route::get('/create', [SalarySetController::class, 'create'])->name('hr.salary-set.create')->middleware('permission:manage-salary-set');
        Route::post('/create', [SalarySetController::class, 'store'])->name('hr.salary-set.store')->middleware('permission:manage-salary-set');
        Route::get('/{id}/edit', [SalarySetController::class, 'edit'])->name('hr.salary-set.edit')->middleware('permission:manage-salary-set');
        Route::post('/{id}/update', [SalarySetController::class, 'update'])->name('hr.salary-set.update')->middleware('permission:manage-salary-set');
        Route::get('/{id}/delete', [SalarySetController::class, 'delete'])->name('hr.salary-set.delete')->middleware('permission:manage-salary-set');
        Route::get('/{id}/change-status/{status}', [SalarySetController::class, 'statusUpdate'])->name('hr.salary-set.change-status')->middleware('permission:manage-salary-set');

        Route::get('/attendance-set/{id}/edit',[SalarySetController::class, 'attendanceSetEdit'])->name('hr.salary-set.attendance-set.edit')->middleware('permission:manage-salary-set');
        Route::post('/attendance-set/{id}/update',[SalarySetController::class, 'attendanceSetUpdate'])->name('hr.salary-set.attendance-set.update')->middleware('permission:manage-salary-set');
        Route::get('/leave-type-set/{id}/edit',[SalarySetController::class, 'leaveTypeSetEdit'])->name('hr.salary-set.leave-type-set.edit')->middleware('permission:manage-salary-set');
        Route::post('/leave-type-set/{id}/update',[SalarySetController::class, 'leaveTypeSetUpdate'])->name('hr.salary-set.leave-type-set.update')->middleware('permission:manage-salary-set');
        Route::get('/{id}/set-employees',[SalarySetController::class, 'setEmployees'])->name('hr.salary-set.set-employees')->middleware('permission:manage-salary-set');
        Route::post('/{id}/set-employees',[SalarySetController::class, 'setEmployeesStore'])->name('hr.salary-set.set-employees.store')->middleware('permission:manage-salary-set');
    });
    // Salary set route end

    // User Leaves route start
    Route::group(['prefix' => 'user-leaves'], function () {
        Route::get('/', [UserLeavesController::class, 'index'])->name('hr.user-leaves')->middleware('permission:view-employee-leave');
        Route::post('/filtered', [UserLeavesController::class, 'indexFiltered'])->name('hr.user-leaves.filtered')->middleware('permission:view-employee-leave');
        Route::get('/create', [UserLeavesController::class, 'create'])->name('hr.user-leaves.create')->middleware('permission:manage-employee-leave');
        Route::post('/create', [UserLeavesController::class, 'store'])->name('hr.user-leaves.store')->middleware('permission:manage-employee-leave');
        Route::get('/{id}/edit', [UserLeavesController::class, 'edit'])->name('hr.user-leaves.edit')->middleware('permission:manage-employee-leave');
        Route::post('/{id}/update', [UserLeavesController::class, 'update'])->name('hr.user-leaves.update')->middleware('permission:manage-employee-leave');
        Route::get('/{id}/delete', [UserLeavesController::class, 'delete'])->name('hr.user-leaves.delete')->middleware('permission:manage-employee-leave');
        Route::get('/{id}/change-status/{status}', [UserLeavesController::class, 'statusUpdate'])->name('hr.user-leaves.change-status')->middleware('permission:manage-employee-leave');
        Route::get('/{id}/status-approve',[UserLeavesController::class, 'statusApprove'])->name('hr.user-leaves.status-approve')->middleware('permission:manage-employee-leave');
        Route::post('/{id}/status-approve',[UserLeavesController::class, 'statusApproveUpdate'])->name('hr.user-leaves.status-approve')->middleware('permission:manage-employee-leave');
        Route::get('/{id}/status-reject',[UserLeavesController::class, 'statusReject'])->name('hr.user-leaves.status-reject')->middleware('permission:manage-employee-leave');
        Route::post('/{id}/status-reject',[UserLeavesController::class, 'statusRejectUpdate'])->name('hr.user-leaves.status-reject')->middleware('permission:manage-employee-leave');
    });
    // User Leaves route end

    // User Resignation Route Start
    Route::group(['prefix' => 'user-resignation'], function () {
        Route::get('/', [UserResignationController::class, 'index'])->name('hr.user-resignation')->middleware('permission:view-employee-resignation');
        Route::post('/filtered', [UserResignationController::class, 'indexFiltered'])->name('hr.user-resignation.filtered')->middleware('permission:view-employee-resignation');
        Route::get('/create', [UserResignationController::class, 'create'])->name('hr.user-resignation.create')->middleware('permission:manage-employee-resignation');
        Route::post('/create', [UserResignationController::class, 'store'])->name('hr.user-resignation.store')->middleware('permission:manage-employee-resignation');
        Route::get('/{id}/edit', [UserResignationController::class, 'edit'])->name('hr.user-resignation.edit')->middleware('permission:manage-employee-resignation');
        Route::post('/{id}/update', [UserResignationController::class, 'update'])->name('hr.user-resignation.update')->middleware('permission:manage-employee-resignation');
        Route::get('/{id}/delete', [UserResignationController::class, 'delete'])->name('hr.user-resignation.delete')->middleware('permission:manage-employee-resignation');
        Route::get('/{id}/change-status/{status}', [UserResignationController::class, 'statusUpdate'])->name('hr.user-resignation.change-status')->middleware('permission:manage-employee-resignation');
        Route::get('/{id}/status-reject',[UserResignationController::class, 'statusReject'])->name('hr.user-resignation.status-reject')->middleware('permission:manage-employee-resignation');
        Route::post('/{id}/status-reject',[UserResignationController::class, 'statusRejectUpdate'])->name('hr.user-resignation.status-reject')->middleware('permission:manage-employee-resignation');
    });
    // User Resignation Route End

    // User Termination route start
    Route::group(['prefix' => 'user-termination'], function () {
        Route::get('/', [UserTerminationController::class, 'index'])->name('hr.user-termination')->middleware('permission:view-employee-termination');
        Route::post('/filtered', [UserTerminationController::class, 'indexFiltered'])->name('hr.user-termination.filtered')->middleware('permission:view-employee-termination');
        Route::get('/create', [UserTerminationController::class, 'create'])->name('hr.user-termination.create')->middleware('permission:manage-employee-termination');
        Route::post('/create', [UserTerminationController::class, 'store'])->name('hr.user-termination.store')->middleware('permission:manage-employee-termination');
        Route::get('/{id}/edit', [UserTerminationController::class, 'edit'])->name('hr.user-termination.edit')->middleware('permission:manage-employee-termination');
        Route::post('/{id}/update', [UserTerminationController::class, 'update'])->name('hr.user-termination.update')->middleware('permission:manage-employee-termination');
        Route::get('/{id}/delete', [UserTerminationController::class, 'delete'])->name('hr.user-termination.delete')->middleware('permission:manage-employee-termination');
    });
    // User Termination route end

    // User Contractors Route Start
    Route::group(['prefix' => 'user-contractor'], function () {
        Route::get('/', [ContractorConroller::class, 'index'])->name('hr.user-contractor')->middleware('permission:view-contractors');
        Route::post('/filtered', [ContractorConroller::class, 'indexFiltered'])->name('hr.user-contractor.filtered')->middleware('permission:view-contractors');
        Route::get('/create', [ContractorConroller::class, 'create'])->name('hr.user-contractor.create')->middleware('permission:manage-contractors');
        Route::post('/create', [ContractorConroller::class, 'store'])->name('hr.user-contractor.store')->middleware('permission:manage-contractors');
        Route::get('/{id}/edit', [ContractorConroller::class, 'edit'])->name('hr.user-contractor.edit')->middleware('permission:manage-contractors');
        Route::post('/{id}/update', [ContractorConroller::class, 'update'])->name('hr.user-contractor.update')->middleware('permission:manage-contractors');
        Route::get('/{id}/delete', [ContractorConroller::class, 'delete'])->name('hr.user-contractor.delete')->middleware('permission:manage-contractors');
    });
    // User Contractors Route End


    // common ajax route start
    Route::group(['prefix' => 'ajax'], function () {
        Route::get('get-designation-by-department', [AjaxController::class, 'getDesignationByDepartment'])->name('ajax.get-designation-by-department');
        Route::get('get-designation-by-multiple-departments', [AjaxController::class, 'getDesignationByMultipleDepartments'])->name('ajax.get-designation-by-multiple-departments');
        Route::get('get-employees',[AjaxController::class,'getEmployees'])->name('ajax.get-employees');
        Route::get('get-employee-by-designation', [AjaxController::class, 'getEmployeeByDesignation'])->name('ajax.get-employee-by-designation');
        Route::get('salary-set/get-employees',[AjaxController::class,'salarySetGetEmployees'])->name('ajax.salary-set.get-employees');
        Route::get('get-leave-type-by-user',[AjaxController::class, 'getLeaveTypeByUser'])->name('ajax.get-leave-type-by-user');
        Route::get('get-employee-total-leave-by-leave-type',[AjaxController::class, 'getEmployeeTotalLeaveByLeaveType'])->name('ajax.get-user-total-leave-by-leave-type');
        Route::get('get-employee-total-leave-by-leave-type-edit',[AjaxController::class, 'getEmployeeTotalLeaveByLeaveTypeEdit'])->name('ajax.get-user-total-leave-by-leave-type-edit');
    });
    // common ajax route end

    // employee attendance route start
    Route::group(['prefix' => 'employee-attendance'], function () {
        Route::get('/', [EmployeeAttendanceController::class, 'index'])->name('hr.employee-attendance')->middleware('permission:view-employee-attendance');
        Route::post('/filtered', [EmployeeAttendanceController::class, 'indexFiltered'])->name('hr.employee-attendance.filtered')->middleware('permission:view-employee-attendance');
        Route::post('/bulk-attendance-store', [EmployeeAttendanceController::class, 'bulkAttendanceStore'])->name('hr.employee-attendance.bulk-attendance-store')->middleware('permission:manage-employee-attendance');
        Route::post('/attendance-store', [EmployeeAttendanceController::class, 'attendanceStore'])->name('hr.employee-attendance.attendance-store')->middleware('permission:manage-employee-attendance');
        Route::get('get-employees-by-attendance-date',[EmployeeAttendanceController::class, 'getEmployeesByAttendanceDate'])->name('hr.employee-attendance.get-employees-by-attendance-date')->middleware('permission:view-employee-attendance');
        Route::post('get-employee-attendance-activity-details-by-date',[EmployeeAttendanceController::class, 'getEmployeeAttendanceActivityDetailsByDate'])->name('hr.employee-attendance.get-employee-attendance-activity-details-by-date')->middleware('permission:view-employee-attendance');
        Route::post('get-employee-attendance-edit-details-by-date',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDate'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date')->middleware('permission:manage-employee-attendance');
        Route::post('get-employee-attendance-edit-details-by-date/edit-form',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDateEditForm'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date.edit-form')->middleware('permission:manage-employee-attendance');
        Route::post('get-employee-attendance-edit-details-by-date/{id}/update',[EmployeeAttendanceController::class, 'getEmployeeAttendanceEditDetailsByDateUpdate'])->name('hr.employee-attendance.get-employee-attendance-edit-details-by-date.update')->middleware('permission:manage-employee-attendance');
    });
    // employee attendance route end

    // Generate Salary Route Start
    Route::group(['prefix' => 'generate-salary', 'middleware' => 'permission:generate-salary'], function () {
        Route::get('/', [GenerateSalaryController::class, 'index'])->name('payroll.generate-salary');
        Route::post('create', [GenerateSalaryController::class, 'create'])->name('payroll.generate-salary.create');
        Route::get('get-salary-generate-details',[GenerateSalaryController::class, 'getSalaryGenerateDetails'])->name('payroll.generate-salary.get-salary-generate-details');
        Route::get('get-salary-set-by-salary-type',[GenerateSalaryController::class, 'getSalarySetBySalaryType'])->name('payroll.generate-salary.get-salary-set-by-salary-type');
    });

    // generated Salary Route Start
    Route::group(['prefix' => 'generated-salary-list'], function () {
        Route::get('/', [GeneratedSalaryController::class, 'index'])->name('payroll.generated-salary')->middleware('permission:view-salary');
        Route::post('/filtered', [GeneratedSalaryController::class, 'indexFiltered'])->name('payroll.generated-salary.filtered')->middleware('permission:view-salary');
        Route::get('/{id}/details', [GeneratedSalaryController::class, 'details'])->name('payroll.generated-salary.details')->middleware('permission:view-salary');
        Route::post('/{id}/details/filtered', [GeneratedSalaryController::class, 'detailsFiltered'])->name('payroll.generated-salary.details.filtered')->middleware('permission:view-salary');
        Route::get('/details/{salary_details_id}/salary-details/edit', [GeneratedSalaryController::class, 'salaryDetailsEdit'])->name('payroll.generated-salary.details.salary-details.edit')->middleware('permission:manage-salary');
        Route::post('/details/{salary_details_id}/salary-details/update', [GeneratedSalaryController::class, 'salaryDetailsUpdate'])->name('payroll.generated-salary.details.salary-details.update')->middleware('permission:manage-salary');
        Route::get('/details/{salary_details_id}/salary-details/show', [GeneratedSalaryController::class, 'salaryDetailsShow'])->name('payroll.generated-salary.details.salary-details.show')->middleware('permission:view-salary');

        /* Route::get('/{id}/edit', [GeneratedSalaryController::class, 'edit'])->name('payroll.generated-salary.edit');
         Route::post('/{id}/update', [GeneratedSalaryController::class, 'update'])->name('payroll.generated-salary.update');
         Route::get('/{id}/delete', [GeneratedSalaryController::class, 'delete'])->name('payroll.generated-salary.delete');*/
    });
});
// HR route end
