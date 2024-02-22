<?php

namespace App\Services\Production\PreProduction;

use App\Models\Machine;
use App\Models\Products\FinishedGoods;
use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;

class PreProductionService
{
    public function __construct()
    {
        $this->paginate_limit = config('commonData.paginate_limit');
    }

    public function createData(){
        $data['machines'] = Machine::where('deleted', Machine::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['categories'] = ProductMaterialCategory::where('deleted', ProductMaterialCategory::DELETED_NO)
            ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();

        $data['finished_products'] = FinishedGoods::where('deleted', FinishedGoods::DELETED_NO)
            ->where('status', FinishedGoods::STATUS_ACTIVE)
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    public function getProducts($id){
        $data['products'] = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', Machine::STATUS_ACTIVE)
            ->where('product_material_category_id', $id)
            ->orderBy('id', 'desc')
            ->get();
        return $data;
    }

    // public function store($request)
    // {
    //     $check_duplicate = Machine::where('name', $request->name)
    //             ->where('deleted', Machine::DELETED_NO)
    //             ->first();
    //     if (!empty($check_duplicate)) {
    //         throw new \Exception("Machine already exists");
    //     }

    //     $image_path = null;
    //     if ($request->hasFile('image')) {
    //         $imageUploadService = new ImageUploadService();
    //         $image_path = $imageUploadService->store($request->image, 'production/machine');
    //         $image_path = $image_path['path'];
    //     }

    //     $machine = new Machine();
    //     $machine->name = $request->name;
    //     $machine->image = $image_path??null;
    //     $machine->model = $request->model;
    //     $machine->color = $request->color;
    //     $machine->description = $request->description;
    //     $machine->created_by = auth()->user()->id;
    //     $machine->created_at = now();
    //     $machine->updated_by = auth()->user()->id;
    //     $machine->updated_at = now();
    //     $machine->save();
    // }
}
