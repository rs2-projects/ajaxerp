<?php

namespace App\Http\Controllers\Production\PreProduction;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Production\PreProduction\PreProductionService;
use App\Http\Requests\Production\PreProduction\StorePreProductionRequest;
use Illuminate\Http\Request;

class PreProductionController extends BackendController
{
    private PreProductionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Pre-Production');

        $this->service = new PreProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Pre-Production");
        $this->setActiveMenu('production.pre-production.index');
        return  $this->view('production.pre-production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('production.pre-production._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function create()
    {
        $this->setPageTitle("Create New Pre-Production");
        $this->setActiveMenu('production.pre-production.index');
        $data = $this->service->createData();
        return  $this->view('production.pre-production.create')->with($data);
    }

    public function store(StorePreProductionRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Pre Prodcution created successfully');
    }

    public function edit($id)
    {
        $this->setPageTitle("Edit Pre-Production");
        $this->setActiveMenu('production.pre-production.index');
        $data = $this->service->editData($id);
        return  $this->view('production.pre-production.edit')->with($data);
    }

    public function getProcess($id)
    {
        $data = $this->service->getProcessData($id);
        return response()->json($data);
    }

    public function getProducts($id){
        return $this->service->getProducts($id);
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Pre Production deleted successfully');
    }

    public function statusUpdate($id, $status)
    {
        try {
            $this->service->statusUpdateData($id, $status);
            return $this->returnAjaxSuccess([], 'Status Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
