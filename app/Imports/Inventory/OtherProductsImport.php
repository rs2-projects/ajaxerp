<?php

namespace App\Imports\Inventory;

use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OtherProductsImport implements ToCollection, WithStartRow
{
    
    public function startRow(): int
    {
        return 2;
    }
    /**
    * @param Collection $collection
    */
    public function collection(Collection $collection)
    {
        foreach ($collection as $item) {
            if($item[0] != '' && $item[1] !='' && $item[2] !='' && $item[3] !='' && $item[4] !='' && $item[5] !=''){
                $check_name = ProductMaterial::where('name', $item[0])
                    ->where('deleted', ProductMaterial::DELETED_NO)
                    ->where('status', ProductMaterial::STATUS_ACTIVE)
                    ->where('type', ProductMaterial::TYPE_OTHERS)
                    ->first();
                if (!empty($check_name)) {
                    throw new \Exception("Product already exists");
                }

                $check_code = ProductMaterial::where('code', $item[1])
                    ->where('deleted', ProductMaterial::DELETED_NO)
                    ->where('status', ProductMaterial::STATUS_ACTIVE)
                    ->first();
                
                if (!empty($check_code)) {
                    throw new \Exception("Code already exists");
                }

                $category = ProductMaterialCategory::where('name', $item[2])
                    ->where('deleted', ProductMaterialCategory::DELETED_NO)
                    ->where('status', ProductMaterialCategory::STATUS_ACTIVE)
                    ->where('type', ProductMaterialCategory::TYPE_OTHERS)
                    ->first();

                if (empty($category)) {
                    throw new \Exception("Category not found");
                }

                $unit = $item[5];
                $unitTypeArr = ProductMaterial::UNIT_TYPES;
                if (!in_array($unit, $unitTypeArr)) {
                    throw new \Exception("Invalid Unit");
                }
                $unitTypeValue = array_search($unit, $unitTypeArr);

                ProductMaterial::create([
                    'type' => ProductMaterial::TYPE_OTHERS,
                    'product_material_category_id' => $category->id,
                    'unit_type' => $unitTypeValue,
                    'name' => $item[0],
                    'code' => $item[1],
                    'low_stock_warning' => $item[3],
                    'low_stock_at_least' => $item[4],
                    'description' => $item[6],
                    'color' => $item[7],
                    'length' => $item[8],
                    'width' => $item[9],
                    'thickness' => $item[10],
                    'created_at' => Carbon::now(),
                    'created_by' => Auth::id(),
                    'updated_at' => Carbon::now(),
                    'updated_by' => Auth::id(),
                ]);
            }
        }
    }
}
