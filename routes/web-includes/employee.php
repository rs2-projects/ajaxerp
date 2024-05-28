<?php

use App\Http\Controllers\User\AttendanceController;
use App\Http\Controllers\User\LeavesController;
use App\Http\Controllers\User\ResignationController;
use Illuminate\Support\Facades\Route;

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
