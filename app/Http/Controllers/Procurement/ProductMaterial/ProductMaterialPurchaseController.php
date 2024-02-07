<?php

namespace App\Http\Controllers\Procurement\ProductMaterial;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Procurement\ProductMaterial\ProductMaterialPurchaseService;
use Illuminate\Http\Request;

class ProductMaterialPurchaseController extends BackendController
{
    private ProductMaterialPurchaseService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Procurement', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material Purchase');

        $this->service = new ProductMaterialPurchaseService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material Purchase");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        return  $this->view('procurement.product-material-purchase.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('procurement.product-material-purchase._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }

    public function create()
    {
        $this->setPageTitle("New Purchase Order");
        $this->setActiveMenu('procurement.product-material-purchase.index');

        return $this->view('procurement.product-material-purchase.create');
    }

    public function getAllProductMaterials(Request $request)
    {
        $data = $this->service->getAllProductMaterials($request);

        return response()->json($data);
    }

    public function getAllTaxes(Request $request)
    {
        $data = $this->service->getAllTaxes($request);

        return response()->json($data['vat_taxes']);
    }
}
