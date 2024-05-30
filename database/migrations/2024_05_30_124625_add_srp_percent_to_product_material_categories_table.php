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
        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->unsignedDecimal('srp_markup_percent', 12, 2)->default(0)->after('name');
            $table->unsignedDecimal('wholesale_discount_percent', 12, 2)->default(0)->after('srp_markup_percent');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->dropColumn('srp_markup_percent');
            $table->dropColumn('wholesale_discount_percent');
        });
    }
};
