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
        Schema::create('salary_settings_salary_sets', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('settings_salary_set_id');
            $table->decimal('total_salary_amount', 12, 2)->default(0)->comment('Total Salary Amount With Salary Addition and Deduction');
            $table->decimal('total_bonus_amount', 12, 2)->default(0)->comment('Total Bonus Amount');
            $table->decimal('total_deduction_amount', 12, 2)->default(0)->comment('Total Deduction(If Salary generate deduction selected) Amount');
            $table->decimal('total_amount_to_pay', 12, 2)->default(0);
            $table->decimal('total_amount_paid', 12, 2)->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('settings_salary_set_id')->references('id')->on('settings_salary_sets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_settings_salary_sets');
    }
};
