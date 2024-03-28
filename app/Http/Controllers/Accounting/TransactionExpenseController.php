<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\Transaction\StoreExpenseRequest;
use App\Services\Accounting\TransactionExpenseService;
use App\Services\Accounting\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionExpenseController extends BackendController
{
    private TransactionExpenseService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Accounting');
        $this->addBreadcrumbs('Transactions');

        $this->service = new TransactionExpenseService();
    }


    public function storeExpense(StoreExpenseRequest $request): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->service->storeExpense($request);
        }catch (\Exception $e){
            DB::rollBack();
            return $this->returnAjaxException($e);
        }
        DB::commit();
        return $this->returnAjaxSuccess([], 'Expense created successfully!');
    }

    public function editExpense($id)
    {
        try {
            $data = $this->service->editExpenseData($id);
            $view = $this->view('accounting.transaction.__edit_expense_modal_data')->with($data)->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e){
            return $this->returnAjaxException($e);
        }
    }

    public function updateExpense(StoreExpenseRequest $request, $id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->service->updateExpense($id, $request);
        }catch (\Exception $e){
            DB::rollBack();
            return $this->returnAjaxException($e);
        }
        DB::commit();
        return $this->returnAjaxSuccess([], 'Expense updated successfully!');
    }

    public function deleteExpense($id): \Illuminate\Http\JsonResponse
    {
        DB::beginTransaction();
        try {
            $this->service->deleteExpense($id);
        }catch (\Exception $e){
            DB::rollBack();
            return $this->returnAjaxException($e);
        }
        DB::commit();
        return $this->returnAjaxSuccess([], 'Expense deleted successfully!');
    }
}
