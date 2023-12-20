<?php

namespace App\Services\Hr;

use App\Models\Department;
use App\Models\Designation;
use App\Models\User;

class EmployeeService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }
    public function getIndexFilteredData($request)
    {
        $keyword = $request->keyword_filtered??null;
        $data['employees'] = User::where('deleted', User::DELETED_NO)
            ->where(function ($query) use ($keyword) {
                if ($keyword != null && $keyword != '') {
                    $query->where('first_name', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('first_name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function getCreateData(){
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }
}
