<?php

namespace App\Http\Controllers\Report\StockReport;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Report\StockReport\AssetProductStockReportService;
use Illuminate\Http\Request;

class AssetProductStockReportController extends BackendController
{
    private AssetProductStockReportService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Report', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Stock Report');
        $this->addBreadcrumbs('Asset Product');

        $this->service = new AssetProductStockReportService();
    }

    public function index()
    {
        $this->setPageTitle("Asset Product Stock Report");
        $this->setActiveMenu('report.asset-product-stock-report');
        return  $this->view('report.stock.asset-product.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('report.stock.asset-product._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
}
