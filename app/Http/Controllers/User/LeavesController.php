<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Requests\User\Leaves\StoreLeavesRequest;
use App\Services\User\LeavesService;
use Illuminate\Http\Request;

class LeavesController extends BackendController
{
    public function __construct()
    {
        $this->addBreadcrumbs('HR', route('user.leaves'), 'fa fa-users');
        $this->addBreadcrumbs('Leaves');
    }

    public function index(Request $request, LeavesService $leavesService)
    {
        $this->setPageTitle("Leaves");
        $this->setActiveMenu('user.leaves');
        $data = $leavesService->getIndexData($request);
        return  $this->view('user.leaves.index')->with($data);
    }

    public function indexFiltered(Request $request, LeavesService $leavesService)
    {
        $data = $leavesService->getIndexFilteredData($request);
        $view = $this->view('user.leaves._index_filtered')->with($data)->render();

        return $this->returnAjaxSuccess(['view' => $view]);
    }

    public function store(StoreLeavesRequest $request, LeavesService $leavesService)
    {
//        return $request->all();
        try {
            $leavesService->store($request);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been created successfully.');
    }

    public function delete($id, LeavesService $leavesService)
    {
        try {
            $leavesService->delete($id);

        }catch (\Exception $exception) {
            return $this->returnAjaxException($exception);
        }
        return $this->returnAjaxSuccess([], 'Leave has been deleted successfully.');
    }
}
