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
        Schema::create('finished_goods_racks', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('warehouse_id');
            $table->unsignedBigInteger('finished_goods_id');
            $table->unsignedBigInteger('warehouse_section_id');
            $table->unsignedBigInteger('warehouse_rack_id');

            $table->unsignedTinyInteger('status')->default(1)->comment('0=inactive,1=active');

            //define foreign keys
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('finished_goods_id')->references('id')->on('finished_goods');
            $table->foreign('warehouse_section_id')->references('id')->on('warehouse_sections');
            $table->foreign('warehouse_rack_id')->references('id')->on('warehouse_section_racks');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finished_goods_racks');
    }
};
