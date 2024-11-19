<?php

namespace App\Http\Controllers\Showroom;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Showroom\StoreShowroomRequest;
use App\Http\Requests\Showroom\UpdateShowroomRequest;
use App\Services\Showroom\ShowroomService;
use Illuminate\Http\Request;

class ShowroomController extends BackendController
{
    private ShowroomService $service;
    public function __construct()
    {
        $this->addBreadcrumbs('Showroom');
        $this->service = new ShowroomService();
    }
    //index
    public function index(){
        $this->setPageTitle('Showroom');
        $this->setActiveMenu('showroom.index');
        $data = $this->service->indexData();
        return $this->view('showroom.index')->with($data);
    }
    
    //index filtered data
    public function indexFiltered(Request $request){
        $data = $this->service->indexFilteredData($request);
        $view = $this->view('showroom._index_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    //store showroom data
    public function store(StoreShowroomRequest $request)
    {
        try {
            $this->service->store($request);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Showroom created successfully');
    }

    //retrieve showroom data for edit
    public function edit($id)
    {
        try {
            $data = $this->service->editData($id);
            $view = $this->view('showroom._edit_data')
            ->with($data)
            ->render();
            return $this->returnAjaxSuccess(['view' => $view], 'Data Fetch Successfully');
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    //update showroom data
    public function update(UpdateShowroomRequest $request, $id)
    {
        try {
            $this->service->update($request,$id);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Showroom updated successfully');
    }

    //delete showroom data
    public function delete($id)
    {
        try {
          $this->service->delete($id);
        }catch(\Exception $e){
            return $this->returnAjaxException($e);
        }
        return $this->returnAjaxSuccess([],'Showroom deleted successfully');
    }

    //showroom employees
    public function showroomEmployees($id)
    {
        $this->setPageTitle('Set Employee');
        $this->addBreadcrumbs('Set Employee');
        $this->setActiveMenu('showroom.index');

        return $this->view('showroom.showroom_employees')->with(['showroomId' => $id]);
    }

    //showroom employees filtered data
    public function showroomEmployeesFiltered(Request $request, $id)
    {
        $data = $this->service->showroomEmployeesFilteredData($request, $id);
        $view = $this->view('showroom._employees_filtered')
            ->with($data)
            ->render();
        return $this->returnAjaxSuccess(['view' => $view]);
    }

    //get empty showroom employees
    public function getEmptyShowroomEmployees(Request $request)
    {
        $data = $this->service->getEmptyShowroomEmployees($request);
        return $this->returnAjaxSuccess($data);
    }

    //store showroom employees
    public function storeShowroomEmployees(Request $request, $id)
    {
        try {
            $this->service->storeShowroomEmployees($request, $id);
        }catch(\Exception $e){
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Employee added successfully');
    }
}
