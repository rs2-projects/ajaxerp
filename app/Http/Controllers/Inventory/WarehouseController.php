<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Inventory\Warehouse\StoreWarehouseRequest;
use App\Http\Requests\Inventory\Warehouse\UpdateWarehouseRequest;
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
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.warehouse._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create()
    {
        $this->setPageTitle("New Warehouse");
        $this->setActiveMenu('inventory.warehouse.create');

        return $this->view('inventory.warehouse.create');
    }

    public function store(StoreWarehouseRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Warehouse created successfully');
    }

    public function edit($id)
    {
        $this->setPageTitle("Edit Warehouse");
        $this->setActiveMenu('inventory.warehouse.index');

        $data = $this->service->getEditData($id);

        if (!$data['warehouse']) {
           return redirect()->route('inventory.warehouse.index')->with('error', 'Warehouse not found');
        }

        return $this->view('inventory.warehouse.edit')->with($data);
    }

    public function update(UpdateWarehouseRequest $request, $id)
    {
        return $this->returnAjaxSuccess([], 'Under development');
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Warehouse updated successfully');
    }

    public function show($id)
    {
        $this->setPageTitle("Warehouse Show");
        $this->setActiveMenu('inventory.warehouse.index');

        $data = $this->service->getShowData($id);

        if (!$data['warehouse']) {
            return redirect()->route('inventory.warehouse.index')->with('error', 'Warehouse not found');
        }

        return $this->view('inventory.warehouse.show')->with($data);
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Warehouse deleted successfully');
    }
}
