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
        Schema::create('product_material_purchase_calculated_prices', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('product_material_purchase_id');
            $table->unsignedBigInteger('product_material_purchase_detail_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedInteger('qty')->default(0);
            $table->unsignedDecimal('price', 12, 2)->default(0);
            $table->unsignedDecimal('exchange_rate', 12, 2)->default(0);
            $table->unsignedDecimal('price_fob', 12, 2)->default(0)->comment('(value = price * exchange_rate) Price FOB in PHP');
            $table->unsignedDecimal('cbm', 12, 2)->default(0);
            $table->unsignedDecimal('total_pieces_per_container', 12, 2)->default(0);
            $table->unsignedDecimal('freight_cost_usd', 12, 2)->default(0);
            $table->unsignedDecimal('exchange_rate_after_import', 12, 2)->default(0);
            $table->unsignedDecimal('freight_cost', 12, 2)->default(0)->comment('(value = (freight_cost_usd / total_pieces_per_container) * exchange_rate_after_import)');
            $table->unsignedDecimal('total_taxes_import_duties', 12, 2)->default(0);
            $table->unsignedDecimal('taxes_import_duties', 12, 2)->default(0)->comment('(value = total_taxes_import_duties / total_pieces_per_container)');
            $table->unsignedDecimal('total_transport_cost_to_wh', 12, 2)->default(0)->comment('Total Transport Cost to Warehouse');
            $table->unsignedDecimal('transport_cost_to_wh', 12, 2)->default(0)->comment('(value = total_transport_cost_to_wh / total_pieces_per_container) Transport Cost to Warehouse');
            $table->unsignedDecimal('total_unloading_cost', 12, 2)->default(0);
            $table->unsignedDecimal('unloading_cost', 12, 2)->default(0)->comment('(value = total_unloading_cost / total_pieces_per_container)');
            $table->unsignedDecimal('handling_cost', 12, 2)->default(0);
            $table->unsignedDecimal('price_excluding_vat', 12, 2)->default(0)->comment('(value = (price_fob + freight_cost + taxes_import_duties + transport_cost_to_wh + unloading_cost) * handling_cost)');
            $table->unsignedDecimal('vat_percent', 12, 2)->default(12);
            $table->unsignedDecimal('vat', 12, 2)->default(0)->comment('(value = (price_excluding_vat / 100) * vat_percent)');
            $table->unsignedDecimal('final_price', 12, 2)->default(0)->comment('(value = price_excluding_vat + vat)');
            $table->unsignedDecimal('total_final_price', 12, 2)->default(0)->comment('(value = final_price * qty)');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('product_material_purchase_id','pmpcp_pmp_id')->references('id')->on('product_material_purchases');
            $table->foreign('product_material_purchase_detail_id','pmpcp_pmpd_id')->references('id')->on('product_material_purchase_details');
            $table->foreign('product_material_id','pmpcp_pm_id')->references('id')->on('product_materials');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_purchase_calculated_prices');
    }
};
