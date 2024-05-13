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
        Schema::create('inventory_asset_products', function (Blueprint $table) {

            $table->id();
            $table->unsignedBigInteger('asset_product_category_id');
            $table->unsignedBigInteger('asset_product_id')->index();
            $table->unsignedTinyInteger('type')->default(0)->comment('0=in,1=out');
            $table->unsignedTinyInteger('reference_type')->default(0)->comment('0=asset_product_purchase,1=asset_product_use etc');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('if reference_type=0 then id from asset_product_purchase_order_details table else id from respective table');
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('asset_product_category_id','iap_apc_id_foreign')->references('id')->on('asset_product_categories');
            $table->foreign('asset_product_id','iap_ap_id_foreign')->references('id')->on('asset_products');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_asset_products');
    }
};
