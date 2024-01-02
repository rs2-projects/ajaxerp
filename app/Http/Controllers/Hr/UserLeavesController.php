<?php

namespace App\Http\Controllers\Hr;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Hr\UserLeaves\StoreUserLeavesRequest;
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

}
