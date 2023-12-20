<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\Department\StoreDepartmentRequest;
use App\Http\Requests\Hr\Department\UpdateDepartmentRequest;
use App\Services\Hr\DepartmentService;
use Illuminate\Http\Request;

class DepartmentController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Department');
    }

    public function index()
    {
        $this->setPageTitle("Department");
        $this->setActiveMenu('hr.department');

       return  $this->view('hr.department.index');
    }

    public function indexFiltered(Request $request, DepartmentService $departmentService)
    {
        $data = $departmentService->getIndexFilteredData($request);
        $view = $this->view('hr.department._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreDepartmentRequest $request, DepartmentService $departmentService)
    {
        try {
            $departmentService->storeDepartment($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(DepartmentService $departmentService, $id)
    {
        try {
            $data = $departmentService->getEditData($id);
            if (empty($data['item'])){
                return throw new \Exception("Data not found");
            }
            $view = $this->view('hr.department._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateDepartmentRequest $request, DepartmentService $departmentService, $id)
    {
        try {
            $departmentService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(DepartmentService $departmentService, $id)
    {
        try {
            $departmentService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
