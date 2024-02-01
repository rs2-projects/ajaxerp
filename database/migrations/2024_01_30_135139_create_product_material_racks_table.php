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
        Schema::create('product_material_racks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedBigInteger('warehouse_section_id');
            $table->unsignedBigInteger('warehouse_rack_id');

            $table->unsignedTinyInteger('status')->default(1)->comment('0=inactive,1=active');

            //define foreign keys
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('product_material_id')->references('id')->on('product_materials');
            $table->foreign('warehouse_section_id')->references('id')->on('warehouse_sections');
            $table->foreign('warehouse_rack_id')->references('id')->on('warehouse_section_racks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_racks');
    }
};
