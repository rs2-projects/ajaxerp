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
        Schema::create('attendance_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index()->comment('id from users table');
            $table->timestamp('datetime');
            $table->unsignedTinyInteger('type')->comment('0: check in, 1: check out');
            $table->string('latitude', 20)->nullable();
            $table->string('longitude', 20)->nullable();
            $table->string('image',128)->nullable();
            $table->unsignedTinyInteger('attendance_by')->comment('0: employee, 1: admin');
            $table->unsignedBigInteger('settings_geo_location_id')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('settings_geo_location_id')->references('id')->on('settings_geo_locations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_histories');
    }
};
