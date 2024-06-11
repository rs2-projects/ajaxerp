<?php

use App\Http\Controllers\Accounting\ChartOfAccountController;
use App\Http\Controllers\Accounting\TransactionController;
use App\Http\Controllers\Accounting\TransactionExpenseController;
use Illuminate\Support\Facades\Route;

// Accounting route start
Route::group(['prefix' => 'accounting'], function (){
    // chart of accounts route start
    Route::group(['prefix' => 'chart-of-accounts'], function () {
        Route::get('/', [ChartOfAccountController::class, 'index'])->name('accounting.chart-of-accounts.index')->middleware('permission:view-chart-of-accounts');
        Route::post('/filtered', [ChartOfAccountController::class, 'indexFiltered'])->name('accounting.chart-of-accounts.filtered')->middleware('permission:view-chart-of-accounts');
        Route::get('/create', [ChartOfAccountController::class, 'create'])->name('accounting.chart-of-accounts.create')->middleware('permission:manage-chart-of-accounts');
        Route::post('/account-create', [ChartOfAccountController::class, 'accountStore'])->name('accounting.chart-of-accounts.account-store')->middleware('permission:manage-chart-of-accounts');
        Route::get('/{id}/edit', [ChartOfAccountController::class, 'accountEdit'])->name('accounting.chart-of-accounts.account-edit')->middleware('permission:manage-chart-of-accounts');
        Route::post('/{id}/update', [ChartOfAccountController::class, 'accountUpdate'])->name('accounting.chart-of-accounts.account-update')->middleware('permission:manage-chart-of-accounts');
        Route::get('/{id}/delete', [ChartOfAccountController::class, 'delete'])->name('accounting.chart-of-accounts.delete')->middleware('permission:manage-chart-of-accounts');
        Route::get('/{id}/change-status/{status}', [ChartOfAccountController::class, 'statusUpdate'])->name('accounting.chart-of-accounts.change-status')->middleware('permission:manage-chart-of-accounts');
    });
    // chart of accounts route end

    Route::prefix('transaction')->group(function () {
        Route::get('/', [TransactionController::class, 'index'])->name('accounting.transaction.index')->middleware('permission:view-transactions');
        Route::post('filtered', [TransactionController::class, 'indexFiltered'])->name('accounting.transaction.index.filtered')->middleware('permission:view-transactions');
        Route::get('{id}/review', [TransactionController::class, 'reviewTransaction'])->name('accounting.transaction.review')->middleware('permission:verify-transactions');

        Route::post('expense', [TransactionExpenseController::class, 'storeExpense'])->name('accounting.transaction.expense.store')->middleware('permission:add-expenses');
        Route::get('expense/{id}/edit', [TransactionExpenseController::class, 'editExpense'])->name('accounting.transaction.expense.edit')->middleware('permission:manage-transactions');
        Route::post('expense/{id}/update', [TransactionExpenseController::class, 'updateExpense'])->name('accounting.transaction.expense.update')->middleware('permission:manage-transactions');
        Route::get('expense/{id}/delete', [TransactionExpenseController::class, 'deleteExpense'])->name('accounting.transaction.expense.delete')->middleware('permission:manage-transactions');
    });
});
// Accounting route end
