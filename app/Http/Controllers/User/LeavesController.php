<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\BaseControllers\BackendController;
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
}
