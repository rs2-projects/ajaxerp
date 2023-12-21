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
        Schema::create('settings_salary_set_employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_salary_set_id');
            $table->unsignedBigInteger('employee_id');
            $table->decimal('basic_salary', 12, 2)->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('settings_salary_set_id')->references('id')->on('settings_salary_sets');
            $table->foreign('employee_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_set_employees');
    }
};
