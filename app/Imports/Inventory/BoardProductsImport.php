<?php

namespace App\Imports\Inventory;

use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BoardProductsImport implements ToCollection, WithStartRow
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
        $default_board_category = ProductMaterialCategory::where('type', ProductMaterialCategory::TYPE_BOARD)
            ->first();
        if (empty($default_board_category)) {
            throw new \Exception('Default board category not found');
        }
        $default_board_category_id = $default_board_category->id;

        foreach ($collection as $item) {
            if($item[0] == null || $item[1] == null || $item[2] == null ){
                continue;
            }

            $product_material = ProductMaterial::where('name', $item[1])
                ->where('product_material_category_id', $default_board_category_id)
                ->where('type', ProductMaterial::TYPE_BOARD)
                ->first();
            if (!empty($product_material)) {
                throw new \Exception("Raw Board with the name '{$item[1]}' already exists");
            }

            $check_name = ProductMaterial::where('name', $item[1])
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->where('status', ProductMaterial::STATUS_ACTIVE)
                ->where('type', ProductMaterial::TYPE_BOARD)
                ->first();

            if (!empty($check_name)) {
                throw new \Exception("Raw Board already exists");
            }
            
            $check_code = ProductMaterial::where('code', $item[0])
                ->where('deleted', ProductMaterial::DELETED_NO)
                ->where('status', ProductMaterial::STATUS_ACTIVE)
                ->first();
            
            if (!empty($check_code)) {
                throw new \Exception("Code '{$item[0]}' already exists");
            }

            $unit = $item[2];
            $unitTypeArr = ProductMaterial::UNIT_TYPES;
            if (!in_array($unit, $unitTypeArr)) {
                throw new \Exception("Invalid Unit");
            }
            $unitTypeValue = array_search($unit, $unitTypeArr);
            
            ProductMaterial::create([
                'type' => ProductMaterial::TYPE_BOARD,
                'product_material_category_id' => $default_board_category_id,
                'unit_type' => $unitTypeValue,
                'name' => $item[1],
                'code' => $item[0],
                'low_stock_warning' => $item[3],
                'low_stock_at_least' => $item[4],
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
