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
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->unsignedDecimal('php_rate', 12, 2)->default(0)->after('estimated_delivery_date');
            $table->unsignedDecimal('subtotal_amount_php', 12, 2)->default(0)->after('php_rate');
            $table->unsignedDecimal('total_vat_amount_php', 12, 2)->default(0)->after('subtotal_amount_php');
            $table->unsignedDecimal('total_discount_amount_php', 12, 2)->default(0)->after('total_vat_amount_php');
            $table->unsignedDecimal('payable_amount_php', 12, 2)->default(0)->after('total_discount_amount_php');
            $table->unsignedDecimal('paid_amount_php', 12, 2)->default(0)->after('payable_amount_php');
            $table->unsignedDecimal('due_amount_php', 12, 2)->default(0)->after('paid_amount_php');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->dropColumn('php_rate');
            $table->dropColumn('subtotal_amount_php');
            $table->dropColumn('total_vat_amount_php');
            $table->dropColumn('total_discount_amount_php');
            $table->dropColumn('payable_amount_php');
            $table->dropColumn('paid_amount_php');
            $table->dropColumn('due_amount_php');
        });
    }
};
