<?php

namespace App\Services\Production\Machine;

use App\Models\MachineCategory;

class MachineCategoryService
{
    public $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['machine_cat_count'] = MachineCategory::where('deleted', MachineCategory::DELETED_NO)->count();
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['machine_categories'] = MachineCategory::where('deleted', MachineCategory::DELETED_NO)
            ->where('name', 'like', '%'.$keyword_filtered.'%')
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        $check_duplicate = MachineCategory::where('name', $request->name)
                ->where('deleted', MachineCategory::DELETED_NO)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Machine already exists");
        }

        $machine_categories = new MachineCategory();
        $machine_categories->name = $request->name;
        $machine_categories->created_by = auth()->user()->id;
        $machine_categories->created_at = now();
        $machine_categories->updated_by = auth()->user()->id;
        $machine_categories->updated_at = now();
        $machine_categories->save();
    }

    public function editData($id)
    {
        $data['item'] = MachineCategory::where('id', $id)
            ->where('deleted', MachineCategory::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Machine category not found');
        }
        return $data;
    }

    public function update($request, $id)
    {
        $machine_categories = MachineCategory::where('id', $id)
            ->where('deleted', MachineCategory::DELETED_NO)
            ->first();
        if (!$machine_categories) {
            throw new \Exception('Machine category not found');
        }

        $check_duplicate = MachineCategory::where('name', $request->name)
                ->where('deleted', MachineCategory::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Machine category already exists");
        }

        $machine_categories->name = $request->name;
        $machine_categories->updated_by = auth()->user()->id;
        $machine_categories->updated_at = now();
        $machine_categories->save();
    }

    public function delete($id)
    {
        $machine_categories = MachineCategory::where('id', $id)
            ->where('deleted', MachineCategory::DELETED_NO)
            ->first();
        if (!$machine_categories) {
            throw new \Exception('Machine category not found');
        }
        $machine_categories->deleted = MachineCategory::DELETED_YES;
        $machine_categories->deleted_by = auth()->user()->id;
        $machine_categories->deleted_at = now();
        $machine_categories->save();
    }
}
