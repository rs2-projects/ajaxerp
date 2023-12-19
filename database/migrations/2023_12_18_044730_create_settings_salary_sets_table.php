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
        Schema::create('settings_salary_sets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unsignedBigInteger('settings_salary_type_id')->nullable();
            $table->unsignedBigInteger('settings_overtime_type_id')->nullable();
            $table->unsignedBigInteger('settings_absent_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_late_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_office_time_type_id')->nullable();

            $table->boolean('attendance_type_fingerprint_device')->default(false)->comment('0=No, 1=Yes');
            $table->boolean('attendance_type_in_geo')->default(false)->comment('0=No, 1=Yes');

            $table->unsignedTinyInteger('salary_generate_type')->default(1)->comment('1=Half Month, 2=Full Month');


            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_sets');
    }
};
