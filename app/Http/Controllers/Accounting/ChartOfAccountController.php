<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Accounting\ChartOfAccountService;
use Illuminate\Http\Request;

class ChartOfAccountController extends BackendController
{
    private ChartOfAccountService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Accounting', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Chart of Account');

        $this->service = new ChartOfAccountService();
    }

    public function index()
    {
        $this->setPageTitle("Chart of Account");
        $this->setActiveMenu('accounting.chart-of-account.index');

        return  $this->view('accounting.chart-of-account.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('accounting.chart-of-account._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }
}
