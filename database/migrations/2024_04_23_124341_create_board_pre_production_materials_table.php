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
        Schema::create('board_pre_production_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('board_pre_production_id')->index('bppm_bpp_id_index');
            $table->unsignedBigInteger('product_material_category_id')->nullable();
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('board_pre_production_id', 'bppm_bpp_id_foreign')->references('id')->on('board_pre_productions');
            $table->foreign('product_material_category_id', 'bppm_pmc_id_foreign')->references('id')->on('product_material_categories');
            $table->foreign('product_material_id', 'bppm_pm_id_foreign')->references('id')->on('product_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_pre_production_materials');
    }
};
