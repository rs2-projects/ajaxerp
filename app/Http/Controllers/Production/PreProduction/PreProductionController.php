<?php

namespace App\Http\Controllers\Production\PreProduction;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Production\PreProduction\PreProductionService;
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

    public function create()
    {
        $this->setPageTitle("Create New Pre-Production");
        $this->setActiveMenu('production.pre-production.index');
        $data = $this->service->createData();
        return  $this->view('production.pre-production.create')->with($data);
    }

    public function getProducts($id){
        return $this->service->getProducts($id);
    }
}
