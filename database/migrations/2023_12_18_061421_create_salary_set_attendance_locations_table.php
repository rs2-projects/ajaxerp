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
        Schema::create('salary_set_attendance_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_set_id');
            $table->unsignedBigInteger('settings_geo_location_id');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_set_attendance_locations');
    }
};
