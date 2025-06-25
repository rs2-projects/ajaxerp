<?php

namespace App\Services\Production\Machine;

use App\Models\Machine;
use App\Models\MachineCategory;
use App\Services\Common\ImageUploadService;

class MachineService
{
    public $paginate_limit;

    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function indexData(){
        $data['machine_count'] = Machine::where('deleted', Machine::DELETED_NO)->count();
        $data['machine_categories'] = MachineCategory::where('deleted', Machine::DELETED_NO)
            ->where('status', MachineCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();
        $data['machine_types'] = Machine::TYPES;
        return $data;
    }

    public function indexFilteredData($request)
    {
        $keyword_filtered = $request->keyword_filtered;
        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where(function ($q) use ($keyword_filtered){
                if ($keyword_filtered !=''){
                    $q->where('name', 'like', '%'.$keyword_filtered.'%')
                        ->orWhere('model', 'like', '%'.$keyword_filtered.'%');
                }
            })
            ->orderBy('id', 'desc')->paginate($this->paginate_limit);

        return $data;
    }

    public function store($request)
    {
        $check_duplicate = Machine::where('name', $request->name)
                ->where('deleted', Machine::DELETED_NO)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Machine already exists");
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'production/machine');
            $image_path = $image_path['path'];
        }

        $machine = new Machine();
        $machine->type = $request->type;
        $machine->category_id = $request->category_id;
        $machine->name = $request->name;
        $machine->image = $image_path??null;
        $machine->model = $request->model;
        $machine->production_cost = $request->production_cost ?? 0;
        $machine->machine_code = $request->machine_code;
        $machine->color = $request->color;
        $machine->description = $request->description;
        $machine->created_by = auth()->user()->id;
        $machine->created_at = now();
        $machine->updated_by = auth()->user()->id;
        $machine->updated_at = now();
        $machine->save();
    }

    public function editData($id)
    {
        $data['item'] = Machine::where('id', $id)
            ->where('deleted', Machine::DELETED_NO)
            ->first();
        if (!$data['item']) {
            throw new \Exception('Machine not found');
        }

        $data['machine_categories'] = MachineCategory::where('deleted', Machine::DELETED_NO)
            ->where('status', MachineCategory::STATUS_ACTIVE)
            ->orderBy('name', 'asc')
            ->get();

        $data['machine_types'] = Machine::TYPES;

        return $data;
    }

    public function update($request, $id)
    {
        $machine = Machine::where('id', $id)
            ->where('deleted', Machine::DELETED_NO)
            ->first();
        if (!$machine) {
            throw new \Exception('Machine not found');
        }

        $check_duplicate = Machine::where('name', $request->name)
                ->where('deleted', Machine::DELETED_NO)
                ->where('id', '!=', $id)
                ->first();
        if (!empty($check_duplicate)) {
            throw new \Exception("Machine already exists");
        }

        $image_path = null;
        if ($request->hasFile('image')) {
            $imageUploadService = new ImageUploadService();
            $image_path = $imageUploadService->store($request->image, 'production/machine');
            $image_path = $image_path['path'];
        }
        $machine->type = $request->type;
        $machine->category_id = $request->category_id;
        $machine->name = $request->name;
        $machine->image = $image_path?? $machine->image;
        $machine->model = $request->model;
        $machine->production_cost = $request->production_cost ?? 0;
        $machine->machine_code = $request->machine_code;
        $machine->color = $request->color;
        $machine->description = $request->description;
        $machine->updated_by = auth()->user()->id;
        $machine->updated_at = now();
        $machine->save();
    }

    public function delete($id)
    {
        $machine = Machine::where('id', $id)
            ->where('deleted', Machine::DELETED_NO)
            ->first();
        if (!$machine) {
            throw new \Exception('Machine not found');
        }
        $machine->deleted = Machine::DELETED_YES;
        $machine->deleted_by = auth()->user()->id;
        $machine->deleted_at = now();
        $machine->save();
    }

    public function getMachine($id)
    {
        $machine = Machine::where('id', $id)
            ->where('deleted', Machine::DELETED_NO)
            ->first();
        if (!$machine) {
            throw new \Exception('Machine not found');
        }
        return $machine;
    }
}
