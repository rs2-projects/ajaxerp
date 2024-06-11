<?php

namespace App\Imports\Inventory;

use App\Models\Products\ProductMaterial;
use App\Models\Products\ProductMaterialCategory;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PaperProductsImport implements ToCollection, WithStartRow
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
        $default_paper_category = ProductMaterialCategory::where('type', ProductMaterialCategory::TYPE_PAPER)
            ->first();
        if (empty($default_paper_category)) {
            throw new \Exception('Default paper category not found');
        }
        $default_paper_category_id = $default_paper_category->id;
        foreach ($collection as $item) {
            if ($item[0] == '') {
                continue;
            }
            //check product material name unique
            $product_material = ProductMaterial::where('name', $item[0])
                ->where('product_material_category_id', $default_paper_category_id)
                ->first();
            if (!empty($product_material)) {
                continue;
            }
            //store product material
            ProductMaterial::create([
                'type' => ProductMaterial::TYPE_PAPER,
                'product_material_category_id' => $default_paper_category_id,
                'unit_type' => ProductMaterial::UNIT_TYPE_PCS,
                'name' => $item[0],
                'code' => $item[0],
                'created_at' => Carbon::now(),
                'created_by' => Auth::id(),
                'updated_at' => Carbon::now(),
                'updated_by' => Auth::id(),
            ]);
        }
    }
}
