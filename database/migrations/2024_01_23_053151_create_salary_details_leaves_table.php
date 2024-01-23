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
        Schema::create('salary_details_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('salary_details_id');
            $table->unsignedBigInteger('employee_id')->nullable();

            $table->date('date')->nullable();
            $table->unsignedTinyInteger('leave_type')->default(2)->comment('0=Not Set, 1=Paid, 2=Unpaid');
            $table->unsignedBigInteger('settings_leave_type_id')->nullable();

            $table->unsignedTinyInteger('salary_type')->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('rate', 6, 2)->default(0)->comment('percentage of basic or gross salary');
            $table->decimal('amount', 12, 2)->default(0)->comment('amount of for unpaid leave');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            // define foreign keys
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('salary_details_id')->references('id')->on('salary_details');
            $table->foreign('employee_id')->references('id')->on('users');
            $table->foreign('settings_leave_type_id')->references('id')->on('settings_leave_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details_leaves');
    }
};
