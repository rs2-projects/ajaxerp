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
        Schema::create('product_requisition_delivery_details_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_requisition_delivery_id');
            $table->unsignedBigInteger('product_requisition_delivery_details_id');
            $table->unsignedBigInteger('product_requisition_id');
            $table->unsignedBigInteger('product_requisition_detail_id');
            $table->unsignedBigInteger('product_material_purchase_detail_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('delivered_qty');
            $table->unsignedBigInteger('received_qty');
            $table->unsignedTinyInteger('received_status')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requisition_delivery_details_items');
    }
};
