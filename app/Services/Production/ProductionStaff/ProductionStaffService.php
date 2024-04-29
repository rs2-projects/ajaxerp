<?php

namespace App\Services\Production\ProductionStaff;

use App\Models\Production\ProductionStaff;

class ProductionStaffService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['staff_count'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)->count();
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['staffs'] = ProductionStaff::where('deleted', ProductionStaff::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('title', 'like', '%'.$keyword_filtered.'%')
                        ->orWhere('user_name', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        $check_duplicate = ProductionStaff::where('user_name', $request->user_name)
                ->where('deleted', ProductionStaff::DELETED_NO)
                ->where('status', ProductionStaff::STATUS_ACTIVE)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Production Staff already exists");
        }
        $machine = new ProductionStaff();
        $machine->title = $request->title;
        $machine->user_name = $request->user_name;
        $machine->password = bcrypt($request->password);
        $machine->remember_token = $request->remember_token ?? null;
        $machine->created_by = auth()->user()->id;
        $machine->created_at = now();
        $machine->updated_by = auth()->user()->id;
        $machine->updated_at = now();
        $machine->save();
    }

    public function editData($id)
    {
        $data['item'] = ProductionStaff::where('id', $id)
            ->where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Production staff not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $staff = ProductionStaff::where('id', $id)
            ->where('deleted', ProductionStaff::DELETED_NO)
            ->where('status', ProductionStaff::STATUS_ACTIVE)
            ->first();
        if (!$staff) {
            throw new \Exception('Production staff not found');
        }

        $check_duplicate = ProductionStaff::where('user_name', $request->user_name)
            ->where('deleted', ProductionStaff::DELETED_NO)
            ->where('id', '!=', $id)
            ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Production staff already exists");
        }
        $staff->title = $request->title;
        $staff->user_name = $request->user_name;
        $staff->password = $staff->password;
        $staff->updated_by = auth()->user()->id;
        $staff->updated_at = now();
        $staff->save();
    }

    public function delete($id)
    {
        $staff = ProductionStaff::where('id', $id)
            ->where('deleted', ProductionStaff::DELETED_NO)
            ->first();
        if (!$staff) {
            throw new \Exception('Production Staff not found');
        }
        $staff->deleted = ProductionStaff::DELETED_YES;
        $staff->deleted_by = auth()->user()->id;
        $staff->deleted_at = now();
        $staff->save();
    }

    public function statusUpdateData($id, $status)
    {
        try {
            $staff = ProductionStaff::where('id', $id)
                ->where('deleted', ProductionStaff::DELETED_NO)
                ->first();
            if (!$staff) {
                throw new \Exception('Production Staff not found');
            }
            $staff->status = $status;
            $staff->updated_by = auth()->user()->id;
            $staff->updated_at = now();
            $staff->save();
        }catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }
}
