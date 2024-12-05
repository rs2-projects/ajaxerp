<?php

use App\Http\Controllers\Showroom\ShowroomController;
use Illuminate\Support\Facades\Route;

// showroom route start
Route::group(['prefix' => 'showroom'], function () {
    Route::get('/', [ShowroomController::class, 'index'])->name('showroom.index')->middleware('permission:view-showroom');
    Route::post('/index-filtered', [ShowroomController::class, 'indexFiltered'])->name('showroom.index.filtered')->middleware('permission:view-showroom');
    Route::post('/store', [ShowroomController::class, 'store'])->name('showroom.store')->middleware('permission:manage-showroom');
    Route::get('{id}/edit', [ShowroomController::class, 'edit'])->name('showroom.edit')->middleware('permission:manage-showroom');
    Route::post('{id}/update', [ShowroomController::class, 'update'])->name('showroom.update')->middleware('permission:manage-showroom');
    Route::get('{id}/delete', [ShowroomController::class, 'delete'])->name('showroom.delete')->middleware('permission:manage-showroom');

    Route::get('{id}/showroom-employees', [ShowroomController::class, 'showroomEmployees'])->name('showroom.showroom-employees.index')->middleware('permission:view-showroom');
    Route::post('{id}/showroom-employees/filtered', [ShowroomController::class, 'showroomEmployeesFiltered'])->name('showroom.showroom-employees.index.filtered')->middleware('permission:view-showroom');
    Route::get('empty-showroom-employees', [ShowroomController::class, 'getEmptyShowroomEmployees'])->name('showroom.showroom-employees.free-employees')->middleware('permission:manage-showroom');
    Route::post('{id}/showroom-employees/store', [ShowroomController::class, 'storeShowroomEmployees'])->name('showroom.showroom-employees.store')->middleware('permission:manage-showroom');
    Route::get('{id}/showroom-employees/{employee_id}/remove', [ShowroomController::class, 'removeShowroomEmployees'])->name('showroom.showroom-employees.remove')->middleware('permission:manage-showroom');
});
