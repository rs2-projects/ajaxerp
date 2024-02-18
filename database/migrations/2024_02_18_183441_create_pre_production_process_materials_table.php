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
        Schema::create('pre_production_process_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_process_id');
            $table->unsignedBigInteger('product_material_category_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedInteger('quantity')->default(0);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppp_materials_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_process_id', 'ppp_materials_ppp_id')->references('id')->on('pre_production_processes');
            $table->foreign('product_material_category_id', 'ppp_materials_pmc_id')->references('id')->on('product_material_categories');
            $table->foreign('product_material_id', 'ppp_materials_pm_id')->references('id')->on('product_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_process_materials');
    }
};
