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
            $table->decimal('wholesale_landed_cost', 16, 6)->nullable()->after('wholesale');
            $table->decimal('wholesale_multiplier', 16, 6)->nullable()->after('wholesale_landed_cost');
            $table->decimal('wholesale_price', 16, 6)->nullable()->after('wholesale_multiplier');
            $table->decimal('retail_multiplier', 16, 6)->nullable()->after('wholesale_price');
            $table->decimal('retail_price', 16, 6)->nullable()->after('retail_multiplier');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_materials', function (Blueprint $table) {
            $table->dropColumn('wholesale_landed_cost');
            $table->dropColumn('wholesale_multiplier');
            $table->dropColumn('wholesale_price');
            $table->dropColumn('retail_multiplier');
            $table->dropColumn('retail_price');
        });
    }
};
