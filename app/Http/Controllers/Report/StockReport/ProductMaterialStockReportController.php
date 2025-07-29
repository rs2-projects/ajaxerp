<?php

namespace App\Http\Controllers\Report\StockReport;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Report\StockReport\ProductMaterialStockReportService;
use Illuminate\Http\Request;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

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
        $this->setPageTitle("Raw Material Stock");
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

    public function exportPdf(Request $request){
        try{
            $data = $this->service->exportPdf($request);
            $pdf = PDF::loadView('report.stock.product-material.export-pdf', $data);
            return $pdf->inline('product_stock_report.pdf');
        }catch (\Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
