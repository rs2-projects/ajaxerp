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
        Schema::table('finished_goods_racks', function (Blueprint $table) {
            $table->unsignedBigInteger('finished_goods_section_id')->nullable()->after('finished_goods_id');
            $table->foreign('finished_goods_section_id', 'fgr_fgs_id_foreign')->references('id')->on('finished_goods_sections');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('finished_goods_racks', function (Blueprint $table) {
            $table->dropColumn('finished_goods_section_id');
        });
    }
};
