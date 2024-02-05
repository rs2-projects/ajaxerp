<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Inventory\ProductMaterialService;
use Illuminate\Http\Request;

class ProductMaterialController extends BackendController
{
    private ProductMaterialService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Product Material');

        $this->service = new ProductMaterialService();
    }

    public function index()
    {
        $this->setPageTitle("Product Material");
        $this->setActiveMenu('inventory.product-material.index');
        $data = $this->service->indexData();
        return  $this->view('inventory.product-material.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.product-material._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
}
