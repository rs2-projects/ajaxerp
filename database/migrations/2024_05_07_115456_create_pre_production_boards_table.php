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
        Schema::create('pre_production_boards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('finished_board_category_id');
            $table->unsignedBigInteger('finished_board_id');
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('delivered_qty')->default(0);
            $table->unsignedInteger('received_qty')->default(0);
            $table->unsignedSmallInteger('scanned_qty')->default(0);
            $table->unsignedSmallInteger('delivery_status')->default(0)->comment('0=Pending, 1=Delivered, 2=Partially Delivered');
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');
            $table->unsignedSmallInteger('scan_status')->default(0)->comment('0=Pending, 1=Scanned, 2=Partially Scanned');


            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('pre_production_id', 'pp_materials_pp_id')->references('id')->on('pre_productions');
            $table->foreign('product_material_category_id', 'pp_materials_pmc_id')->references('id')->on('product_material_categories');
            $table->foreign('product_material_id', 'pp_materials_pm_id')->references('id')->on('product_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_boards');
    }
};
