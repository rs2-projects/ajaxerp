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
        Schema::table('attendance_reports', function (Blueprint $table) {
            $table->unsignedTinyInteger('salary_generated')->default(0)->after('inputted_by_type')->comment('0=no,1=yes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_reports', function (Blueprint $table) {
            $table->dropColumn('salary_generated');
        });
    }
};
