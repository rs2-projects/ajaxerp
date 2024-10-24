<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\UserTermination\StoreUserTerminationRequest;
use App\Http\Requests\Hr\UserTermination\UpdateUserTerminationRequest;
use App\Services\Hr\UserTerminationService;
use Illuminate\Support\Facades\Request;


class UserTerminationController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('hr.user-termination'), 'fa fa-users');
        $this->addBreadcrumbs('User Termination');
    }

    public function index(UserTerminationService $userTerminationService)
    {
        $this->setPageTitle("User Termination");
        $this->setActiveMenu('hr.user-termination');
        $data = $userTerminationService->getIndexData();
        return  $this->view('hr.user-termination.index')->with($data);
    }

    public function indexFiltered(Request $request, UserTerminationService $userTerminationService)
    {
        $data = $userTerminationService->getIndexFilteredData($request);
        $view = $this->view('hr.user-termination._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreUserTerminationRequest $request, UserTerminationService $userTerminationService)
    {
        try {
            $userTerminationService->store($request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Create Success");
    }

    public function edit(UserTerminationService $userTerminationService, $id)
    {
        try {
            $data = $userTerminationService->getEditData($id);
            if (empty($data['item'])){
                throw new \Exception("Data not found");
            }
            $view = $this->view('hr.user-termination._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateUserTerminationRequest $request, UserTerminationService $userTerminationService, $id)
    {
        try {
            $userTerminationService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Update Success");
    }

    public function delete(UserTerminationService $userTerminationService, $id)
    {
        try {
            $userTerminationService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Delete Success");
    }
}
