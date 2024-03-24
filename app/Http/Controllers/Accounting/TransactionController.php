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

    public function index()
    {
        $this->setPageTitle("Transactions");
        $this->setActiveMenu('accounting.transaction.index');
        $data = $this->service->indexData();
        return  $this->view('accounting.transaction.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('accounting.transaction._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function storeExpense(Request $request)
    {

    }
}
