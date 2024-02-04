<?php

namespace App\Http\Controllers\Accounting;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Accounting\ChartOfAccount\StoreAccountRequest;
use App\Http\Requests\Accounting\ChartOfAccount\UpdateAccountRequest;
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
        $data = $this->service->indexData();
        return  $this->view('accounting.chart-of-account.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('accounting.chart-of-account._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function accountStore(StoreAccountRequest $request)
    {
        try {
            $this->service->storeAccount($request);
        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Account has been created successfully');
    }

    public function accountEdit($id)
    {
        $data = $this->service->editAccountData($id);
        $view = $this->view('accounting.chart-of-account._edit_account_data')->with($data)->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function accountUpdate(UpdateAccountRequest $request, $id)
    {
        try {
            $this->service->updateAccount($request, $id);
        }catch (\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Account has been updated successfully');
    }
}
