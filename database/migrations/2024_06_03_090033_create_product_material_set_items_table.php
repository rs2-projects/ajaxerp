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
        Schema::create('product_material_set_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_set_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedDecimal('rp_cost', 12, 2)->default(0);
            $table->unsignedDecimal('rp_srp', 12, 2)->default(0);
            $table->unsignedDecimal('srp_with_discount', 12, 2)->default(0);
            $table->unsignedDecimal('wholesale', 12, 2)->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_set_items');
    }
};
