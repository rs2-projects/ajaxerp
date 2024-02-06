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
}
