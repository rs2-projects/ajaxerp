<?php

namespace App\Services\Ajax;

use App\Models\Designation;

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
}
