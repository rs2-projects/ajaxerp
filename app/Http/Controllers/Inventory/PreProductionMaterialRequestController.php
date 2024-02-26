<?php

namespace App\Http\Controllers\Inventory;
use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\Inventory\PreProductionMaterialRequestService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PreProductionMaterialRequestController extends BackendController
{
    private PreProductionMaterialRequestService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Material Request (Production)');

        $this->service = new PreProductionMaterialRequestService();
    }

    public function index()
    {
        $this->setPageTitle("Material Request (Production)");
        $this->setActiveMenu('inventory.material-request.index');
        return $this->view('inventory.material-request.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.material-request._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function deliver($id)
    {
        $this->setPageTitle("Material Request (Production)");
        $this->setActiveMenu('inventory.material-request.deliver');
        $data = $this->service->deliverData($id);
        return $this->view('inventory.material-request.deliver')->with($data);
    }
}
