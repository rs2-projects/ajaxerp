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
        Schema::create('asset_product_purchase_order_damage_files', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('asset_product_purchase_order_id');
            $table->unsignedBigInteger('asset_product_purchase_order_detail_id')->index('appodf_appod_id_index');
            $table->unsignedTinyInteger('file_type')->default(0)->comment('0=damage,1=missing');
            $table->string('file_path', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('asset_product_purchase_order_id', 'appodf_appo_id_foreign')->references('id')->on('asset_product_purchase_orders');
            $table->foreign('asset_product_purchase_order_detail_id', 'appodf_appod_id_foreign')->references('id')->on('asset_product_purchase_order_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_purchase_order_damage_files');
    }
};
