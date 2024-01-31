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
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('employee_id')->index()->comment('id from users table');
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('settings_salary_set_id');
            $table->unsignedBigInteger('salary_settings_salary_set_id')->nullable();
            $table->unsignedBigInteger('settings_salary_type_id')->nullable();
            $table->unsignedBigInteger('settings_overtime_type_id')->nullable();
            $table->unsignedBigInteger('settings_absent_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_late_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_office_time_type_id')->nullable();

            $table->unsignedInteger('total_days')->default(0);
            $table->unsignedInteger('total_working_days')->default(0);
            $table->unsignedInteger('total_weekend_days')->default(0);
            $table->unsignedInteger('holiday_days')->default(0);
            $table->unsignedInteger('total_present_days')->default(0);
            $table->unsignedInteger('perfect_present_days')->default(0);
            $table->unsignedInteger('late_present_days')->default(0);
            $table->unsignedInteger('early_departure_days')->default(0);
            $table->unsignedInteger('absent_days')->default(0);
            $table->unsignedInteger('total_leave_days')->default(0);
            $table->unsignedInteger('paid_leave_days')->default(0);
            $table->unsignedInteger('extra_leave_days')->default(0);

            $table->decimal('monthly_basic_salary', 12, 2)->default(0)->comment('without any deduction and addition');
            $table->decimal('daily_basic_salary', 12, 2)->default(0)->comment('without any deduction and addition');
            $table->decimal('net_basic_salary', 12,2)->default(0)->comment('based on worked days with calculate using absent, and extra leaves during salary period');

            $table->decimal('monthly_total_added_salary', 12, 2)->default(0)->comment('salary default addition from settings_salary_type_details based on total month');
            $table->decimal('total_added_salary', 12, 2)->default(0)->comment('salary default addition from settings_salary_type_details based on current salary period');
            $table->decimal('monthly_total_deducted_salary', 12, 2)->default(0)->comment('salary default deduction from settings_salary_type_details based on total month');
            $table->decimal('total_deducted_salary', 12, 2)->default(0)->comment('salary default deduction from settings_salary_type_details based on current salary period');

            $table->decimal('monthly_salary', 12, 2)->default(0)->comment('with calculate default addition and deduction');
            $table->decimal('daily_salary', 12, 2)->default(0)->comment('with calculate default addition and deduction');
            $table->decimal('current_period_salary', 12, 2)->default(0)->comment('with calculate default addition and deduction');

            $table->unsignedTinyInteger('absent_day_rate_type')->default(0)->comment('0=percent,1=fixed_amount');
            $table->unsignedTinyInteger('absent_day_salary_type')->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('absent_day_rate', 10, 2)->default(0)->comment('percentage or fixed amount');
            $table->decimal('absent_day_amount_per_day', 12, 2)->default(0);
            $table->decimal('absent_day_amount', 12, 2)->default(0);

            $table->decimal('extra_leave_amount', 12, 2)->default(0);

            $table->unsignedInteger('normal_day_overtime_minutes')->default(0);
            $table->decimal('normal_day_overtime_rate_per_hour', 10,2)->default(0);
            $table->decimal('normal_day_overtime_rate_per_minute', 10,2)->default(0);
            $table->decimal('normal_day_overtime_amount', 12, 2)->default(0);

            $table->unsignedInteger('special_day_overtime_minutes')->default(0);
            $table->decimal('special_day_overtime_rate_per_hour',10,2)->default(0);
            $table->decimal('special_day_overtime_rate_per_minute',10,2)->default(0);
            $table->decimal('special_day_overtime_amount', 12, 2)->default(0);

            $table->unsignedInteger('late_minutes')->default(0);
            $table->decimal('late_rate_per_hour', 10,2)->default(0);
            $table->decimal('late_rate_per_minute', 10,2)->default(0);
            $table->decimal('late_amount', 12, 2)->default(0);

            $table->unsignedInteger('early_departure_minutes')->default(0);
            $table->decimal('early_departure_rate_per_hour', 10,2)->default(0);
            $table->decimal('early_departure_rate_per_minute', 10,2)->default(0);
            $table->decimal('early_departure_amount', 12, 2)->default(0);

            $table->decimal('total_bonus_amount', 12, 2)->default(0);

            $table->unsignedBigInteger('settings_deduction_type_id')->nullable();
            $table->decimal('deduction_rate_type', 10,2)->default(1)->comment('1=Percentage, 2=Amount');
            $table->decimal('deduction_salary_type', 10,2)->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('deduction_rate', 10, 2)->default(0)->comment('percentage or fixed amount');
            $table->decimal('deduction_amount', 12, 2)->default(0);

            $table->string('custom_add_amount_text', 255)->nullable();
            $table->decimal('custom_add_amount', 12, 2)->default(0);
            $table->string('custom_deduct_amount_text', 255)->nullable();
            $table->decimal('custom_deduct_amount', 12, 2)->default(0);

            $table->decimal('net_payable_salary', 12, 2)->default(0);
            $table->decimal('paid_salary', 12, 2)->default(0);
            $table->unsignedTinyInteger('salary_paid_status')->default(0)->comment('0=Not Paid, 1=Paid, 2=Partial Paid');

            $table->unsignedTinyInteger('slip_generated')->default(0)->comment('0=Not Generated, 1=Generated');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('settings_salary_set_id')->references('id')->on('settings_salary_sets');
            $table->foreign('settings_salary_type_id')->references('id')->on('settings_salary_types');
            $table->foreign('settings_overtime_type_id')->references('id')->on('settings_overtime_types');
            $table->foreign('settings_absent_penalty_id')->references('id')->on('settings_absent_penalties');
            $table->foreign('settings_late_penalty_id')->references('id')->on('settings_late_penalties');
            $table->foreign('settings_office_time_type_id')->references('id')->on('settings_office_time_types');
            $table->foreign('settings_deduction_type_id')->references('id')->on('settings_salary_deduction_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};
