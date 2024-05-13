<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Accounting\TransactionService;
use Illuminate\Http\Request;

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

    public function reviewTransaction(Request $request, $id)
    {
        try {
            $this->service->reviewTransaction($id, $request);
        }catch (\Exception $e){
            return $this->returnAjaxException($e);
        }
        return $this->returnAjaxSuccess([], 'Transaction reviewed successfully!');
    }

}
