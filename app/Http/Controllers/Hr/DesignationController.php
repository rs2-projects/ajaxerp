<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\Designation\StoreDesignationRequest;
use App\Http\Requests\Hr\Designation\UpdateDesignationRequest;
use App\Services\Hr\DesignationService;
use Illuminate\Http\Request;

class DesignationController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Designation');
    }

    public function index(Request $request, DesignationService $designationService)
    {
        $this->setPageTitle("Designation");
        $this->setActiveMenu('hr.designation');

        $data = $designationService->indexData($request);

        return  $this->view('hr.designation.index')->with($data);
    }

    public function indexFiltered(Request $request, DesignationService $designationService)
    {
        $data = $designationService->getIndexFilteredData($request);
        $view = $this->view('hr.designation._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreDesignationRequest $request, DesignationService $designationService)
    {
        try {
            $designationService->storeDesignation($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(DesignationService $designationService, $id)
    {
        try {
            $data = $designationService->getEditData($id);
            if (empty($data['item'])){
                throw new \Exception("Data not found");
            }
            $view = $this->view('hr.designation._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateDesignationRequest $request, DesignationService $designationService, $id)
    {
        try {
            $designationService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(DesignationService $designationService, $id)
    {
        try {
            $designationService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
