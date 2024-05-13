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
            $table->boolean('board_price_calculated')->after('price_calculated_by')->default(false)->comment('If true, it means that the price has been calculated');
            $table->timestamp('board_price_calculated_at')->after('board_price_calculated')->nullable();
            $table->unsignedBigInteger('board_price_calculated_by')->after('board_price_calculated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->dropColumn('board_price_calculated');
            $table->dropColumn('board_price_calculated_at');
            $table->dropColumn('board_price_calculated_by');
        });
    }
};
