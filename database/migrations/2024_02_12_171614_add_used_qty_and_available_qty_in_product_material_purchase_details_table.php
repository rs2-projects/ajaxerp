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
        Schema::table('product_material_purchase_details', function (Blueprint $table) {
            $table->unsignedInteger('used_qty')->default(0)->after('qty');
            $table->unsignedInteger('available_qty')->default(0)->after('used_qty');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchase_details', function (Blueprint $table) {
            $table->dropColumn('used_qty');
            $table->dropColumn('available_qty');
        });
    }
};
