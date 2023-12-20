<?php

namespace App\Services\Hr;

use App\Models\Department;
use App\Models\Designation;
use Carbon\Carbon;

class DesignationService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData($request)
    {
        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->where('status', Department::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;
    }

    public function getIndexFilteredData($request)
    {
        $keyword = $request->keyword_filtered??null;
        $data['designations'] = Designation::where('deleted', Designation::DELETED_NO)
            ->where(function ($query) use ($keyword) {
                if ($keyword != null && $keyword != '') {
                    $query->where('name', 'LIKE', "%{$keyword}%");
                }
            })
            ->orderBy('name', 'asc')
            ->paginate($this->paginate_limit);

        return $data;
    }

    public function storeDesignation($request)
    {
        try {
            $designation = new Designation();
            $designation->name = $request->name;
            $designation->department_id = $request->department_id;
            $designation->description = $request->description;
            $designation->created_by = auth()->id();
            $designation->created_at = Carbon::now();
            $designation->updated_by = auth()->id();
            $designation->updated_at = Carbon::now();
            $designation->save();
        }catch (\Exception $exception) {
            return throw new \Exception($exception->getMessage());
        }
    }

    public function getEditData($id)
    {
        $data['item'] = Designation::where('deleted', Designation::DELETED_NO)
            ->where('id', $id)
            ->first();

        $data['departments'] = Department::where('deleted', Department::DELETED_NO)
            ->where('status', Department::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        return $data;

    }

    public function update($request, $id)
    {
        try {

            $designation = Designation::where('deleted', Designation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$designation) {
                return throw new \Exception("Data not found");
            }
            $designation->name = $request->name;
            $designation->department_id = $request->department_id;
            $designation->description = $request->description;
            $designation->updated_by = auth()->id();
            $designation->updated_at = Carbon::now();
            $designation->save();

        }catch (\Exception $exception) {
            return  throw new \Exception($exception->getMessage());
        }

    }

    public function delete($id)
    {
        try {
            $designation = Designation::where('deleted', Designation::DELETED_NO)
                ->where('id', $id)
                ->first();
            if (!$designation) {
                return throw new \Exception("Data not found");
            }
            $designation->deleted = Designation::DELETED_YES;
            $designation->deleted_at = Carbon::now();
            $designation->deleted_by = auth()->id();
            $designation->save();
        }catch (\Exception $exception) {
            return throw new \Exception($exception->getMessage());
        }
    }
}
