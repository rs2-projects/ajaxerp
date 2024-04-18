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
            $table->unsignedTinyInteger('both_side_color')->default(0)->comment('0=no,1=yes')->after('available_qty');
            $table->string('downside_color',64)->nullable()->after('color');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_materials', function (Blueprint $table) {
            $table->dropColumn('both_side_color');
            $table->dropColumn('downside_color');
        });
    }
};
