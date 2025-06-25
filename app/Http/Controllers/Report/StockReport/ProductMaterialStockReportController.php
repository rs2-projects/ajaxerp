<?php

namespace App\Http\Controllers\Report\StockReport;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Report\StockReport\ProductMaterialStockReportService;
use Illuminate\Http\Request;

class ProductMaterialStockReportController extends BackendController
{
    private ProductMaterialStockReportService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Report', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Stock Report');
        $this->addBreadcrumbs('Product Material');

        $this->service = new ProductMaterialStockReportService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Stock Report");
        $this->setActiveMenu('report.product-material-stock-report');
        return  $this->view('report.stock.product-material.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('report.stock.product-material._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
}
