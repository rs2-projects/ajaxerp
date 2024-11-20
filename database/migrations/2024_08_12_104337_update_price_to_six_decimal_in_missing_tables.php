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
        Schema::table('board_embosseds', function (Blueprint $table) {
            $table->unsignedDecimal('production_cost', 16, 6)->default(0)->change();
        });

        Schema::table('contractors', function (Blueprint $table) {
            $table->unsignedDecimal('contract_value', 24, 6)->default(0)->change();
        });

        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->unsignedDecimal('srp_markup_percent', 24, 6)->default(0)->change();
            $table->unsignedDecimal('wholesale_discount_percent', 24, 6)->default(0)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {

    }
};
