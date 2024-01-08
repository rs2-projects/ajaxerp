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
        Schema::table('attendance_histories', function (Blueprint $table) {
            $table->unsignedBigInteger('settings_geo_location_id')->nullable()->after('attendance_by');
            //define relationships
            $table->foreign('settings_geo_location_id')->references('id')->on('settings_geo_locations');
        });
        Schema::table('attendance_history_todays', function (Blueprint $table) {
            $table->unsignedBigInteger('settings_geo_location_id')->nullable()->after('attendance_by');
            //define relationships
            $table->foreign('settings_geo_location_id')->references('id')->on('settings_geo_locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('attendance_histories', function (Blueprint $table) {
            $table->dropForeign(['settings_geo_location_id']);
            $table->dropColumn('settings_geo_location_id');
        });
        Schema::table('attendance_history_todays', function (Blueprint $table) {
            $table->dropForeign(['settings_geo_location_id']);
            $table->dropColumn('settings_geo_location_id');
        });
    }
};
