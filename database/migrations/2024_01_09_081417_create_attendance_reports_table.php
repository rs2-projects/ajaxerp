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
        Schema::create('attendance_reports', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id');
            $table->unsignedBigInteger('settings_salary_set_id')->nullable();
            $table->date('date');
            $table->timestamp('time_in')->nullable();
            $table->timestamp('time_out')->nullable();
            $table->unsignedTinyInteger('time_in_status')->default(0)->comment('0=Not Set, 1=On Time, 2=Late');
            $table->unsignedTinyInteger('time_out_status')->default(0)->comment('0=Not Set, 1=On Time, 2=Early');
            $table->boolean('is_present')->default(false)->comment('0=Absent, 1=Present');
            $table->boolean('is_holiday')->default(false)->comment('0=Not Holiday, 1=Holiday');
            $table->boolean('is_weekend')->default(false)->comment('0=Not Weekend, 1=Weekend');
            $table->boolean('is_leave')->default(false)->comment('0=Not Leave, 1=Leave');
            $table->unsignedTinyInteger('leave_type')->nullable()->comment('0=Not Set, 1=Paid, 2=Unpaid');
            $table->unsignedBigInteger('settings_leave_type_id')->nullable();
            $table->string('total_work_time',8)->nullable();
            $table->string('total_overtime',8)->nullable();
            $table->string('normal_day_overtime',8)->nullable();
            $table->string('special_day_overtime',8)->nullable();
            $table->string('total_break_time',8)->nullable();
            $table->string('late_time',8)->nullable();
            $table->string('early_leaving_time',8)->nullable();
            $table->unsignedTinyInteger('inputted_by_type')->default(0)->comment('0=Cron, 1=Employee, 2=Admin');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('settings_salary_set_id')->references('id')->on('settings_salary_sets');
            $table->foreign('settings_leave_type_id')->references('id')->on('settings_leave_types');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendance_reports');
    }
};
