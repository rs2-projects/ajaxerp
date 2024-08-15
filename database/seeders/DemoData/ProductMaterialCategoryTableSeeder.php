<?php

namespace Database\Seeders\DemoData;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductMaterialCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_material_categories')->insert([
            'type' => \App\Models\Products\ProductMaterialCategory::TYPE_BOARD,
            'calculator_type' => \App\Models\Products\ProductMaterialCategory::CALCULATOR_TYPE_BOARDS,
            'name' => 'Boards',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('product_material_categories')->insert([
            'type' => \App\Models\Products\ProductMaterialCategory::TYPE_PAPER,
            'calculator_type' => \App\Models\Products\ProductMaterialCategory::CALCULATOR_TYPE_BOARDS,
            'name' => 'Papers',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
