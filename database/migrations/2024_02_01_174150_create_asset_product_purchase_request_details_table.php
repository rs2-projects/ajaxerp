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
        Schema::create('asset_product_purchase_request_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_product_purchase_request_id');
            $table->unsignedBigInteger('asset_product_category_id');
            $table->unsignedBigInteger('asset_product_id');
            $table->unsignedInteger('qty')->default(0);
            $table->text('description')->nullable();
            $table->string('file', 255)->nullable();

            $table->unsignedTinyInteger('is_purchased')->default(0)->comment('0=no,1=yes [check if create a purchase order for this item]');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('asset_product_purchase_request_id', 'apprd_appr_id_foreign')->references('id')->on('asset_product_purchase_requests');
            $table->foreign('asset_product_category_id', 'apprd_apc_id_foreign')->references('id')->on('asset_product_categories');
            $table->foreign('asset_product_id', 'apprd_ap_id_foreign')->references('id')->on('asset_products');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_purchase_request_details');
    }
};
