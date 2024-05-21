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
        Schema::table('asset_product_purchase_order_details', function (Blueprint $table) {
            $table->unsignedDecimal('unit_price_php', 12, 2)->default(0)->after('unit_price');
            $table->unsignedDecimal('total_price_php', 12, 2)->default(0)->after('total_price');
            $table->unsignedDecimal('tax_amount_php', 12, 2)->default(0)->after('tax_amount');
            $table->unsignedDecimal('net_total_php', 12, 2)->default(0)->after('net_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('asset_product_purchase_order_details', function (Blueprint $table) {
            $table->dropColumn('unit_price_php');
            $table->dropColumn('total_price_php');
            $table->dropColumn('tax_amount_php');
            $table->dropColumn('net_total_php');
        });
    }
};
