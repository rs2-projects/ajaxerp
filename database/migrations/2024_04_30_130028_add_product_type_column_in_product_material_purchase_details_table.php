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
            $table->unsignedTinyInteger('product_type')->default(0)->comment('0=Others,1=Board,2=Paper')->after('product_material_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_purchase_details', function (Blueprint $table) {
            $table->dropColumn('product_type');
        });
    }
};
