<?php

namespace App\Http\Controllers\ProductionStaff;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Services\ProductionStaff\RequisitionService;
use Illuminate\Http\Request;

class ProductRequisitionController extends BackendController
{
    private RequisitionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Home', route('production-staff.dashboard'), 'fa fa-home');

        $this->service = new RequisitionService();
    }

    public function index()
    {
        $this->setPageTitle('Requisition');
        $this->setActiveMenu('production-staff.requisition.index');
        return $this->view('production-staff.requisition.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFiltered($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function create() 
    {
        $this->setPageTitle('Create Requisition');
        $this->setActiveMenu('production-staff.requisition.create');

        $data = $this->service->createData();

        return $this->view('production-staff.requisition.create')->with($data);
    }

    public function store(Request $request) {
        try {
            $data = $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess($data, 'Requisition Store successfully');
    }

    public function details($id) {
        $this->setPageTitle('Requisition Details');
        $this->setActiveMenu('production-staff.requisition.index');

        $data = $this->service->details($id);

        return $this->view('production-staff.requisition.details')->with($data);
    }
}
