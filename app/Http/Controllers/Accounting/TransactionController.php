<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Accounting\Transaction\StoreExpenseRequest;
use App\Services\Accounting\TransactionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends BackendController
{
    private TransactionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Accounting');
        $this->addBreadcrumbs('Transactions');

        $this->service = new TransactionService();
    }

    public function index(): \Illuminate\Contracts\View\View
    {
        $this->setPageTitle("Transactions");
        $this->setActiveMenu('accounting.transaction.index');
        $data = $this->service->indexData();
        return $this->view('accounting.transaction.index')->with($data);
    }

    public function indexFiltered(Request $request): \Illuminate\Http\JsonResponse
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('accounting.transaction._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
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
        return $this->returnAjaxSuccess([], 'Expense created successfully!');
    }
}
