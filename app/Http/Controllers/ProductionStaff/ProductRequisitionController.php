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
}
