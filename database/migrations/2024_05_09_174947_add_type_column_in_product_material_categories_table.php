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
        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(0)->comment('0=Others,1=Boards,2=Paper')->after('id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_material_categories', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
