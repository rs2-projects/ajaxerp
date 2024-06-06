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
        Schema::table('product_material_set_items', function (Blueprint $table) {
            $table->unsignedInteger('quantity')->default(0)->after('product_material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_set_items', function (Blueprint $table) {
            $table->dropColumn('quantity');
        });
    }
};
