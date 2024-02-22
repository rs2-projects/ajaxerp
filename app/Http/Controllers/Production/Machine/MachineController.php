<?php

namespace App\Http\Controllers\Production\Machine;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Production\Machine\StoreMachineRequest;
use App\Http\Requests\Production\Machine\UpdateMachineRequest;
use App\Services\Production\Machine\MachineService;
use Illuminate\Http\Request;

class MachineController extends BackendController
{
    private MachineService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Dashboard', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Machine');

        $this->service = new MachineService();
    }

    public function index()
    {
        $this->setPageTitle("Machine");
        $this->setActiveMenu('production.machine.index');
        $data = $this->service->indexData();

        return  $this->view('production.machine.index')->with($data);
    }

    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('production.machine._index_filtered')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreMachineRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Machine created successfully');
    }

    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('production.machine._edit_data')
                ->with($data)
                ->render();
            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function update(UpdateMachineRequest $request, $id)
    {
        try {
            $this->service->update($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Machine updated successfully');
    }

    public function delete($id)
    {
        try {
            $this->service->delete($id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Machine deleted successfully');
    }
}
