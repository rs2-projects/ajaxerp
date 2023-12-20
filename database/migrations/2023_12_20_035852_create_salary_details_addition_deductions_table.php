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
        Schema::create('salary_details_addition_deductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('salary_details_id');
            $table->unsignedBigInteger('settings_salary_type_id')->nullable();
            $table->unsignedBigInteger('settings_salary_type_details_id')->nullable();
            $table->unsignedTinyInteger('type')->default(0)->comment('0=earning/allowance,1=deduction');
            $table->decimal('rate',6,2)->default(0)->comment('percentage of basic salary');
            $table->decimal('amount',12,2)->default(0)->comment('amount of earning/allowance or deduction');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details_addition_deductions');
    }
};
