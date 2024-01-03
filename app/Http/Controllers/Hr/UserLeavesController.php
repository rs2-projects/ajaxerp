<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hr\UserLeaves\ApproveUserLeavesRequest;
use App\Http\Requests\Hr\UserLeaves\StoreUserLeavesRequest;
use App\Http\Requests\Hr\UserLeaves\UpdateUserLeavesRequest;
use App\Services\Hr\UserLeavesService;
use Illuminate\Http\Request;

class UserLeavesController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('dashboard'), 'fa fa-home');
        $this->addBreadcrumbs('Leaves');
    }

    public function index(Request $request, UserLeavesService $leavesService)
    {
        $this->setPageTitle("Leaves");
        $this->setActiveMenu('hr.user-leaves');
        $data = $leavesService->getIndexData($request);

         return  $this->view('hr.user-leaves.index')->with($data);
    }

    public function indexFiltered(Request $request, UserLeavesService $leavesService)
    {
        $data = $leavesService->getIndexFilteredData($request);
        $view = $this->view('hr.user-leaves._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreUserLeavesRequest $request, UserLeavesService $leavesService)
    {
        try {
            $leavesService->store($request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been created successfully.');
    }

    public function edit($id, UserLeavesService $leavesService)
    {
        try {
            $data = $leavesService->edit($id);
            $view = $this->view('hr.user-leaves._edit_data')->with($data)->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
    }

    public function update($id, UpdateUserLeavesRequest $request, UserLeavesService $leavesService)
    {
        try {
            $leavesService->update($id, $request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been updated successfully.');
    }

    public function delete($id, UserLeavesService $leavesService)
    {
        try {
            $leavesService->delete($id);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been deleted successfully.');
    }

    public function statusApprove($id, UserLeavesService $leavesService)
    {
        try {
            $data = $leavesService->statusApprove($id);
            $view = $this->view('hr.user-leaves._approve_data')->with($data)->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

    }

    public function statusApproveUpdate($id, ApproveUserLeavesRequest $request, UserLeavesService $leavesService)
    {
        try {
            $leavesService->statusApproveUpdate($id, $request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been approved successfully.');
    }

    public function statusReject($id, UserLeavesService $leavesService)
    {
        try {
            $data = $leavesService->statusReject($id);
            $view = $this->view('hr.user-leaves._reject_data')->with($data)->render();

            return $this->returnAjaxSuccess(['view' => $view]);
        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }

    }

    public function statusRejectUpdate($id, Request $request, UserLeavesService $leavesService)
    {
        try {
            $leavesService->statusRejectUpdate($id, $request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been rejected successfully.');
    }
}
