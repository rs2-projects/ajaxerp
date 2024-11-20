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
        Schema::create('product_requisition_details', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_requisition_id');
            $table->unsignedSmallInteger('product_type')->default(0)->comment('0=Other,1=Board');
            $table->unsignedBigInteger('product_id');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedInteger('delivered_qty')->default(0);
            $table->unsignedSmallInteger('delivery_status')->default(0)->comment('0=Pending, 1=Delivered, 2=Partially Delivered');
            $table->unsignedInteger('received_qty')->default(0);
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_details');
    }
};
