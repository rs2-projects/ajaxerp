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
        Schema::create('pre_production_material_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_material_delivery_id');
            $table->unsignedBigInteger('pre_production_material_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedInteger('total_quantity')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('received_qty')->default(0);
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppmdd_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_material_delivery_id', 'ppmdd_ppmd_id')->references('id')->on('pre_production_material_deliveries');
            $table->foreign('pre_production_material_id', 'ppmdd_ppm_id')->references('id')->on('pre_production_materials');
            $table->foreign('product_material_id', 'ppmdd_pm_id')->references('id')->on('product_materials');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_material_delivery_details');
    }
};
