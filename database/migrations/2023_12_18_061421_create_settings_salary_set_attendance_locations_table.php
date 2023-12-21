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
        Schema::create('settings_salary_set_attendance_locations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_salary_set_id');
            $table->unsignedBigInteger('settings_geo_location_id');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('settings_salary_set_id', 'sssal_sss_id_foreign')->references('id')->on('settings_salary_sets');
            $table->foreign('settings_geo_location_id', 'sssal_sgl_id_foreign')->references('id')->on('settings_geo_locations');
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
