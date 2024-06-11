<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('finished_goods', function (Blueprint $table) {
            \Illuminate\Support\Facades\DB::select("ALTER TABLE finished_goods DROP FOREIGN KEY `finished_goods_color_up_foreign`;");
            \Illuminate\Support\Facades\DB::select("ALTER TABLE finished_goods DROP FOREIGN KEY `finished_goods_color_down_foreign`;");
            \Illuminate\Support\Facades\DB::select("ALTER TABLE `finished_goods` DROP INDEX `finished_goods_color_up_foreign`;");
            \Illuminate\Support\Facades\DB::select("ALTER TABLE `finished_goods` DROP INDEX `finished_goods_color_down_foreign`;");

            $table->foreign('color_up')->references('id')->on('product_materials');
            $table->foreign('color_down')->references('id')->on('product_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finished_goods', function (Blueprint $table) {
            //
        });
    }
};
