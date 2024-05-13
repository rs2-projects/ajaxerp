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
        Schema::create('pre_production_board_delivery_details_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_board_delivery_id');
            $table->unsignedBigInteger('pre_production_board_delivery_details_id');
            $table->unsignedBigInteger('pre_production_board_id');
            $table->unsignedBigInteger('finished_board_id');
            $table->string('barcode', 64);
            $table->boolean('received')->default(false);
            $table->boolean('scanned')->default(false);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppbddi_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_board_delivery_id', 'ppbddi_ppbd_id')->references('id')->on('pre_production_board_deliveries');
            $table->foreign('pre_production_board_delivery_details_id', 'ppbddi_ppbdd_id')->references('id')->on('pre_production_board_delivery_details');
            $table->foreign('pre_production_board_id', 'ppbddi_ppb_id')->references('id')->on('pre_production_boards');
            $table->foreign('finished_board_id', 'ppbddi_fg_id')->references('id')->on('finished_goods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_board_delivery_details_items');
    }
};
