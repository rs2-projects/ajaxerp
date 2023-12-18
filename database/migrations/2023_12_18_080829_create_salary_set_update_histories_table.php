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
        Schema::create('salary_set_update_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_set_id');
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('settings_salary_type_id')->nullable();
            $table->unsignedBigInteger('settings_overtime_type_id')->nullable();
            $table->unsignedBigInteger('settings_absent_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_late_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_office_time_type_id')->nullable();

            $table->boolean('attendance_type_fingerprint_device')->default(false)->comment('0=No, 1=Yes');
            $table->boolean('attendance_type_in_geo')->default(false)->comment('0=No, 1=Yes');


            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_set_update_histories');
    }
};
