<?php

namespace Database\Seeders\DemoData;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinishedGoodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('finished_goods_categories')->insert([
            'id' => 1,
            'name' => 'Category 1',
            'description' => 'Category 1 description',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('finished_goods_categories')->insert([
            'id' => 2,
            'name' => 'Category 2',
            'description' => 'Category 2 description',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('finished_goods')->insert([
            'id' => 1,
            'finished_goods_category_id' => 1,
            'name' => 'Product 1',
            'code' => 'P1',
            'image' => null,
            'description' => 'Product 1 description',
            'comments' => 'Product 1 comments',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('finished_goods')->insert([
            'id' => 2,
            'finished_goods_category_id' => 2,
            'name' => 'Product 2',
            'code' => 'P2',
            'image' => null,
            'description' => 'Product 2 description',
            'comments' => 'Product 2 comments',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('finished_goods')->insert([
            'id' => 3,
            'finished_goods_category_id' => 1,
            'name' => 'Product 3',
            'code' => 'P3',
            'image' => null,
            'description' => 'Product 3 description',
            'comments' => 'Product 3 comments',
            'status' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
