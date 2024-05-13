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
        Schema::table('pre_production_material_delivery_details_items', function (Blueprint $table) {
            $table->unsignedSmallInteger('scanned')->default(0)->after('received');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_material_delivery_details_items', function (Blueprint $table) {
            $table->dropColumn('scanned');
        });
    }
};
