<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\Hr\UserResignation\StoreUserResigationRequst;
use App\Http\Requests\Hr\UserResignation\UpdateUserResigationRequst;
use App\Services\Hr\UserResignationService;
use Illuminate\Http\Request;

class UserResignationController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('hr.user-resignation'), 'fa fa-users');
        $this->addBreadcrumbs('Resignation');
    }

    public function index(Request $request, UserResignationService $userResignationService)
    {
        $this->setPageTitle("Resignation");
        $this->setActiveMenu('hr.user-resignation');
        $data = $userResignationService->getIndexData($request);
        return  $this->view('hr.user-resignation.index')->with($data);
    }

    public function indexFiltered(Request $request, UserResignationService $userResignationService)
    {
        $data = $userResignationService->getIndexFilteredData($request);
        $view = $this->view('hr.user-resignation._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreUserResigationRequst $request, UserResignationService $userResignationService)
    {
        try {
            $userResignationService->store($request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been created successfully.');
    }

    public function edit(UserResignationService $userResignationService, $id)
    {
        try {
            $data = $userResignationService->getEditData($id);
            if (empty($data['item'])){
                throw new \Exception("Data not found");
            }
            $view = $this->view('hr.user-resignation._edit_data')->with($data)
                ->render();
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function update(UpdateUserResigationRequst $request, UserResignationService $userResignationService, $id)
    {
        try {
            $userResignationService->update($request, $id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been updated successfully.');
    }

    public function delete(UserResignationService $userResignationService, $id)
    {
        try {
            $userResignationService->delete($id);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been deleted successfully.');
    }

    public function statusUpdate(UserResignationService $userResignationService, $id, $status)
    {
        try {
            $userResignationService->statusUpdate($id, $status);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], "Status Update Success");
    }

    public function statusReject(UserResignationService $userResignationService, $id)
    {
        try {
            $data = $userResignationService->statusReject($id);
            $view = $this->view('hr.user-resignation._reject_data')->with($data)->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }

    public function statusRejectUpdate(Request $request, UserResignationService $userResignationService, $id)
    {
        try {
            $userResignationService->statusRejectUpdate($id, $request);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Resignation has been rejected successfully.');
    }


}
