<?php

namespace Database\Seeders;

use Database\Seeders\DemoData\FinishedGoodsTableSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call(FinishedGoodsTableSeeder::class);
    }
}
