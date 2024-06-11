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
        Schema::table('pre_production_process_materials', function (Blueprint $table) {
            $table->unsignedTinyInteger('type')->default(3)->comment('0=Raw Board,1=Paper Up,2=Paper Down,3=Other')->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_process_materials', function (Blueprint $table) {
            $table->dropColumn('type');
        });
    }
};
