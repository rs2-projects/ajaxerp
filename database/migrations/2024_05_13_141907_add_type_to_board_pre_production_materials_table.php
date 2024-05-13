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
        Schema::table('board_pre_production_materials', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(0)->comment('0=Raw Board,1=Paper Up, 2=Paper Down')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_pre_production_materials', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
