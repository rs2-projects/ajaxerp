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
        Schema::create('pre_production_board_deliveries', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_no', 50)->comment('Delivery Number should be unique');
            $table->timestamp('delivery_date');
            $table->unsignedBigInteger('pre_production_id');

            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');
            $table->unsignedSmallInteger('scan_status')->default(0)->comment('0=Pending, 1=Scanned, 2=Partially Scanned');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('pre_production_id', 'ppbd_pp_id')->references('id')->on('pre_productions');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_board_deliveries');
    }
};
