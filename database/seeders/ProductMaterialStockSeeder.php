<?php

namespace Database\Seeders;

use App\Models\Inventory\ProductMaterialStock;
use App\Models\Products\ProductMaterial;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductMaterialStockSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $today = Carbon::today()->toDateString();

        $materials = ProductMaterial::where('deleted', ProductMaterial::DELETED_NO)
            ->where('status', ProductMaterial::STATUS_ACTIVE)
            ->get();

        foreach ($materials as $material) {
            ProductMaterialStock::create([
                'date'                       => $today,
                'product_material_category_id' => $material->product_material_category_id,
                'product_material_id'        => $material->id,
                'product_material_type'      => $material->type,
                'type'                      => 0, // stock IN
                'reference_type'            => 0, // initial_stock
                'reference_id'              => null,
                'quantity'                  => $material->available_qty,
            ]);
        }
    }
}
