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
        Schema::table('product_material_racks', function (Blueprint $table) {
            $table->unsignedBigInteger('product_material_section_id')->nullable()->after('product_material_id');
            $table->foreign('product_material_section_id', 'pmr_pms_id_foreign')->references('id')->on('product_material_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_racks', function (Blueprint $table) {
            $table->dropColumn('product_material_section_id');
        });
    }
};
