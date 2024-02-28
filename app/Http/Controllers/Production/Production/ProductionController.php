<?php

namespace App\Http\Controllers\Production\Production;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Services\Production\Production\ProductionService;
use Illuminate\Http\Request;

class ProductionController extends BackendController
{
    private ProductionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Production');

        $this->service = new ProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Production");
        $this->setActiveMenu('production.production.index');
        return $this->view('production.production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('production.production._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

}
