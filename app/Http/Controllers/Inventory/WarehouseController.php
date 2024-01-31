<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Inventory\WarehouseService;
use Illuminate\Http\Request;

class WarehouseController extends BackendController
{
    private WarehouseService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Inventory', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Warehouse');

        $this->service = new WarehouseService();
    }

    public function index()
    {
        $this->setPageTitle("Warehouse");
        $this->setActiveMenu('inventory.warehouse.index');

        return  $this->view('inventory.warehouse.index');
    }

    public function indexFiltered(Request $request)
    {

        $view = $this->view('inventory.warehouse._index_filtered')
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create()
    {
        $this->setPageTitle("New Warehouse");
        $this->setActiveMenu('inventory.warehouse.create');

        return $this->view('inventory.warehouse.create');
    }
}
