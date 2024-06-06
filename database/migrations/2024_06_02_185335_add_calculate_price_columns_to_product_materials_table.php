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
        Schema::table('product_materials', function (Blueprint $table) {
            $table->unsignedTinyInteger('price_calculated')->default(0)->comment('0=No,1=Yes')->after('comments');
            $table->unsignedDecimal('rp_cost', 12, 2)->default(0)->after('price_calculated');
            $table->unsignedDecimal('srp_markup_percent', 12, 2)->default(0)->after('rp_cost');
            $table->unsignedDecimal('wholesale_discount_percent', 12, 2)->default(0)->after('srp_markup_percent');
            $table->unsignedDecimal('rp_srp', 12, 2)->default(0)->after('wholesale_discount_percent');
            $table->unsignedDecimal('srp_with_discount', 12, 2)->default(0)->after('rp_srp');
            $table->unsignedDecimal('wholesale', 12, 2)->default(0)->after('srp_with_discount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_materials', function (Blueprint $table) {
            $table->dropColumn('price_calculated');
            $table->dropColumn('rp_cost');
            $table->dropColumn('srp_markup_percent');
            $table->dropColumn('wholesale_discount_percent');
            $table->dropColumn('rp_srp');
            $table->dropColumn('srp_with_discount');
            $table->dropColumn('wholesale');
        });
    }
};
