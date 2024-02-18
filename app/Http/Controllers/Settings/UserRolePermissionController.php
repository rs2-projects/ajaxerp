<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\BaseControllers\BackendController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Settings\UserRolePermission\StoreRolePermissionRequest;
use App\Services\Settings\UserRolePermissionService;
use Illuminate\Http\Request;

class UserRolePermissionController extends BackendController
{   
    private UserRolePermissionService $service;

    public function __construct()
    {
        $this->addBreadcrumbs('Settings', route('settings.office-time'), 'fa fa-cog');
        $this->addBreadcrumbs('Role Management');
        $this->service = new UserRolePermissionService();
    }

    public function index($id)
    {
        try {
            $data = $this->service->indexData($id);
            // dd($data);
            return  $this->view('settings.user-role.role-permission.index')->with($data);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
    }

    public function store(StoreRolePermissionRequest $request, $id)
    {
        try {
            $this->service->store($request, $id);
        }catch (\Exception $e) {
            return $this->returnAjaxError([],$e->getMessage());
        }
        return $this->returnAjaxSuccess([], 'Role Permission added successfully');
    }
}
