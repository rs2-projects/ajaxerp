<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\User\Resignation\StoreResignationRequest;
use App\Http\Requests\User\Resignation\UpdateResignationRequest;
use App\Services\User\ResignationService;
use Illuminate\Http\Request;

class ResignationController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('user.resignation'), 'fa fa-users');
        $this->addBreadcrumbs('Resignation');
    }

    public function index(Request $request, ResignationService $resignationService)
    {
        $this->setPageTitle("Resignation");
        $this->setActiveMenu('user.resignation');
        $data = $resignationService->getIndexData($request);
        return  $this->view('user.resignation.index')->with($data);
    }

    public function indexFiltered(Request $request, ResignationService $resignationService)
    {
        $data = $resignationService->getIndexFilteredData($request);
        $view = $this->view('user.resignation._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreResignationRequest $request, ResignationService $resignationService)
    {
        try {
            $resignationService->store($request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been created successfully.');
    }

    public function edit(ResignationService $resignationService, $id)
    {
        try {
            $data = $resignationService->getEditData($id);
            if (empty($data['item'])){
                return throw new \Exception("Data not found");
            }
            $view = $this->view('user.resignation._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateResignationRequest $request, ResignationService $resignationService, $id)
    {
        try {
            $resignationService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been updated successfully.');
    }

    public function delete(ResignationService $resignationService, $id)
    {
        try {
            $resignationService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been deleted successfully.');
    }
}
