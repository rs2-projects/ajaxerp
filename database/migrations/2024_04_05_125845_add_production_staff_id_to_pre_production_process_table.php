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
        Schema::table('pre_production_processes', function (Blueprint $table) {
            $table->unsignedTinyInteger('production_staff_id')->after('pre_production_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_processes', function (Blueprint $table) {
            $table->dropColumn('production_staff_id');
        });
    }
};
