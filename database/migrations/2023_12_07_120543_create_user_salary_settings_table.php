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
        Schema::create('user_salary_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->unsignedBigInteger('settings_salary_type_id')->nullable();
            $table->unsignedBigInteger('settings_overtime_type_id')->nullable();
            $table->unsignedBigInteger('settings_absent_penalty_id')->nullable();
            $table->unsignedBigInteger('settings_late_penalty_id')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_salary_settings');
    }
};
