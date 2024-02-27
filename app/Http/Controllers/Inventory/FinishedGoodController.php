<?php

namespace App\Http\Controllers\Inventory;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Inventory\FinishedGood\StoreFinishedGoodRequest;
use App\Http\Requests\Inventory\FinishedGood\UpdateFinishedGoodRequest;
use App\Services\Inventory\FinishedGoodService;
use Illuminate\Http\Request;

class FinishedGoodController extends BackendController
{
    private FinishedGoodService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Inventory',route('dashboard'),'fa fa-home');
        $this->addBreadcrumbs('Finished Good');
        $this->service = new FinishedGoodService();
    }
    //index data
    public function index()
    {
        $this->setPageTitle('Finished Good');
        $this->setActivemenu('inventory.finished-good.index');
        $data = $this->service->indexData();
        return $this->view('inventory.finished-good.index')->with($data);

    }
    //filtered data
    public function indexFiltered(Request $request)
    {
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('inventory.finished-good._index_filtered')
        ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view],'Data Fetch Successfully');
    }
    //warehouse
    public function getSectionsByWarehouse(Request $request)
    {
        $data = $this->service->getSectionsByWarehouseData($request);
        $view = $this->view('inventory.finished-good.__section_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');

    }
    //rack by section
    public function getRacksBySections(Request $request)
    {
        $data = $this->service->getRacksBySectionsData($request);
        $view = $this->view('inventory.finished-good.__rack_options')
            ->with($data)
            ->render();

        return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
    }
    //store finished good data
    public function store(StoreFinishedGoodRequest $request)
    {
        try {
            $this->service->storeData($request);
            return $this->returnAjaxSuccess([], 'Data Save Successfully');
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    //edit finished good data
    public function edit($id)
    {
        try {
            $this->setPageTitle("Edit Finished Good");
            $this->setActiveMenu('inventory.finished-good.index');
            $data = $this->service->editData($id);
            return $this->view('inventory.finished-good.edit')
                ->with($data);
        }catch(\Exception $e){
            return redirect()->route('inventory.finished-good.index')->with('error', $e->getMessage());
        }
    }
    //update finished goods data
    public function update(UpdateFinishedGoodRequest $request, $id)
    {
        try {
            $this->service->updateData($request, $id);
            return $this->returnAjaxSuccess([], 'Data Update Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
    //delete finished goods data
    public function delete($id)
    {
        try {
            $this->service->deleteData($id);
            return $this->returnAjaxSuccess([], 'Data Delete Successfully');
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }
}
