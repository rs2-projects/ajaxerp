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
        Schema::create('asset_product_purchase_order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_product_purchase_order_id')->index('appod_appo_id_index');
            $table->unsignedBigInteger('asset_product_id');

            $table->unsignedBigInteger('asset_product_purchase_request_id')->nullable()->index('appod_appr_id_index');
            $table->unsignedBigInteger('asset_product_purchase_request_detail_id')->nullable()->index('appod_apprd_id_index');

            $table->text('description')->nullable();
            $table->string('warranty', 64)->nullable();

            $table->unsignedInteger('qty')->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0)->comment('qty * unit_price');

            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('tax_rate', 10, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);

            $table->decimal('net_total', 12, 2)->default(0)->comment('total_price + tax_amount');

            $table->unsignedTinyInteger('is_perfect')->default(0)->comment('0=no,1=yes');
            $table->unsignedTinyInteger('has_damage')->default(0)->comment('0=no,1=yes');
            $table->unsignedInteger('damage_qty')->default(0);
            $table->string('damage_remarks', 255)->nullable();
            $table->unsignedTinyInteger('has_missing')->default(0)->comment('0=no,1=yes');
            $table->unsignedInteger('missing_qty')->default(0);
            $table->string('missing_remarks', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('asset_product_purchase_order_id', 'appod_appo_id_foreign')->references('id')->on('asset_product_purchase_orders');
            $table->foreign('asset_product_id', 'appod_ap_id_foreign')->references('id')->on('asset_products');
            $table->foreign('asset_product_purchase_request_id', 'appod_appr_id_foreign')->references('id')->on('asset_product_purchase_requests');
            $table->foreign('asset_product_purchase_request_detail_id', 'appod_apprd_id_foreign')->references('id')->on('asset_product_purchase_request_details');
            $table->foreign('tax_id', 'appod_tax_id_foreign')->references('id')->on('acc_coa_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_purchase_order_details');
    }
};
