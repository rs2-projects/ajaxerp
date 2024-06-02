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
        Schema::table('board_pre_productions', function (Blueprint $table) {
            $table->unsignedTinyInteger('price_calculated')->default(0)->comment('0=No,1=Yes')->after('note');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('board_pre_productions', function (Blueprint $table) {
            $table->dropColumn('price_calculated');
        });
    }
};
