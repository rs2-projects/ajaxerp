<?php

namespace App\Http\Controllers\Production\BoardPreProduction;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\BoardPreProduction\StoreBoardPreProductionRequest;
use App\Http\Requests\Production\BoardPreProduction\UpdateBoardPreProductionRequest;
use App\Services\Production\BoardPreProduction\BoardPreProductionService;
use Illuminate\Http\Request;

class BoardPreProductionController extends BackendController
{
    private BoardPreProductionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Board Pre-Production');

        $this->service = new BoardPreProductionService();
    }

    public function index()
    {
        $this->setPageTitle("Board Pre-Production");
        $this->setActiveMenu('production.board-pre-production.index');
        return  $this->view('production.board-pre-production.index');
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        return $this->returnAjaxSuccess(['view' => $data['view']], 'Data Fetch Successfully');
    }

    public function create()
    {
        $this->setPageTitle("Create Board Pre-Production");
        $this->setActiveMenu('production.board-pre-production.index');
        $data = $this->service->createData();
        return  $this->view('production.board-pre-production.create')->with($data);
    }

    public function getMaterialByCategory(Request $request){
        try {
            $data = $this->service->getMaterialByCategory($request);
            $view = $this->view('production-staff.production._get_material_by_category')->with($data)
                ->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function store(StoreBoardPreProductionRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Pre Prodcution created successfully');
    }

    public function edit($id)
    {
        $this->setPageTitle("Edit Board Pre-Production");
        $this->setActiveMenu('production.board-pre-production.index');
        $data = $this->service->editData($id);
        return  $this->view('production.board-pre-production.edit')->with($data);
    }

    public function update(UpdateBoardPreProductionRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Pre Production updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Board Pre Production deleted successfully');
    }

    public function details($id){
        try {
            $data = $this->service->detailsData($id);
            $view = $this->view('production.board-pre-production._send_to_production_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
