<?php

namespace App\Services\Hr;

use App\Models\Department;
use Carbon\Carbon;

class DepartmentService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function getIndexFilteredData($request)
    {
        $keyword = $request->keyword_filtered??null;
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->where(function ($query) use ($keyword) {
                if ($keyword != null && $keyword != '') {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeDepartment($request)
    {
        $department = new Department();
        $department->name = $request->name;
        $department->description = $request->description;
        $department->created_by = auth()->id();
        $department->created_at = Carbon::now();
        $department->updated_by = auth()->id();
        $department->updated_at = Carbon::now();
        $department->save();
    }

    public function getEditData($id)
    {
        $data['item'] = Department::where('deleted', Department::DELETED_NO)
            ->where('id', $id)
            ->first();

        return $data;

    }

    public function update($request, $id)
    {
        try {

            $department = Department::where('deleted', Department::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$department) {
                return throw new \Exception("Data not found");
            }
            $department->name = $request->name;
            $department->description = $request->description;
            $department->updated_by = auth()->id();
            $department->updated_at = Carbon::now();
            $department->save();

        }catch (\Exception $exception) {
          return  throw new \Exception($exception->getMessage());
        }

    }

    public function delete($id)
    {
        try {
            $department = Department::where('deleted', Department::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$department) {
                return throw new \Exception("Data not found");
            }
            $department->deleted = Department::DELETED_YES;
            $department->deleted_at = Carbon::now();
            $department->deleted_by = auth()->id();
            $department->save();
        }catch (\Exception $exception) {
            return throw new \Exception($exception->getMessage());
        }
    }
}
