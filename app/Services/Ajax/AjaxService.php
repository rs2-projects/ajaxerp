<?php

namespace App\Services\Ajax;

use App\Models\Designation;
use App\Models\User;

class AjaxService
{
    public function getDesignationByDepartment($request)
    {
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->where('status', Designation::STATUS_ACTIVE)
            ->where('department_id', $request->department_id)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }

    public function getEmployees($request)
    {
        $keyword = $request->keyword ?? null;
        $department_id = $request->department_id?? null;
        $designation_id = $request->designation_id?? null;
        $data['getEmployees'] = User::where('deleted', User::DELETED_NO)
            ->where('status', User::STATUS_ACTIVE)
            ->where('role', User::ROLE_EMPLOYEE)
            ->where('type', User::TYPE_EMPLOYEE)
            ->where(function ($q) use ($keyword) {
                if (!empty($keyword)) {
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%')
                        ->orWhere('employee_id', 'like', '%' . $keyword . '%');
                }
            })
            ->where(function ($q) use ($department_id) {
                if (!empty($department_id)) {
                    $q->where('department_id', $department_id);
                }
            })
            ->where(function ($q) use ($designation_id) {
                if (!empty($designation_id)) {
                    $q->where('designation_id', $designation_id);
                }
            })
            ->orderBy('first_name', 'asc')
            ->get();

        return $data;
    }
}
