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
        Schema::create('pre_production_board_delivery_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_board_delivery_id');
            $table->unsignedBigInteger('pre_production_board_id');
            $table->unsignedBigInteger('finished_board_id');
            $table->unsignedInteger('total_quantity')->default(0);
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedInteger('received_qty')->default(0);
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');
            $table->unsignedInteger('scanned_qty')->default(0);
            $table->unsignedSmallInteger('scan_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Scanned');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppbdd_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_board_delivery_id', 'ppbdd_ppbd_id')->references('id')->on('pre_production_board_deliveries');
            $table->foreign('pre_production_board_id', 'ppbdd_ppb_id')->references('id')->on('pre_production_boards');
            $table->foreign('finished_board_id', 'ppbdd_fg_id')->references('id')->on('finished_goods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_board_delivery_details');
    }
};
