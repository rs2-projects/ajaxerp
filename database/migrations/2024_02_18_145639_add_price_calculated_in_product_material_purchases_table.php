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
            $table->boolean('price_calculated')->after('invoice_footer')->default(false)->comment('If true, it means that the price has been calculated');
            $table->timestamp('price_calculated_at')->after('price_calculated')->nullable();
            $table->unsignedBigInteger('price_calculated_by')->after('price_calculated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchases', function (Blueprint $table) {
            $table->dropColumn('price_calculated');
            $table->dropColumn('price_calculated_at');
            $table->dropColumn('price_calculated_by');
        });
    }
};
