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
        Schema::create('pre_production_material_delivery_details_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_material_delivery_id');
            $table->unsignedBigInteger('pre_production_material_delivery_details_id');
            $table->unsignedBigInteger('pre_production_material_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedBigInteger('product_material_purchase_details_id');
            $table->string('barcode', 64);
            $table->boolean('received')->default(false);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppmddi_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_material_delivery_id', 'ppmddi_ppmd_id')->references('id')->on('pre_production_material_deliveries');
            $table->foreign('pre_production_material_delivery_details_id', 'ppmddi_ppmdd_id')->references('id')->on('pre_production_material_delivery_details');
            $table->foreign('pre_production_material_id', 'ppmddi_ppm_id')->references('id')->on('pre_production_materials');
            $table->foreign('product_material_id', 'ppmddi_pm_id')->references('id')->on('product_materials');
            $table->foreign('product_material_purchase_details_id', 'ppmddi_pmpd_id')->references('id')->on('product_material_purchase_details');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_material_delivery_details_items');
    }
};
