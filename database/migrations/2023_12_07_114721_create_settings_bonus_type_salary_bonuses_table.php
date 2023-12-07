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
        Schema::create('settings_bonus_type_salary_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_bonus_type_id');
            $table->unsignedBigInteger('settings_salary_type_id');
            $table->unsignedTinyInteger('rate_type')->default(0)->comment('0=percent,1=fixed_amount');
            $table->unsignedTinyInteger('salary_type')->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('rate', 10, 2)->default(0)->comment('percentage or fixed amount');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_bonus_type_salary_bonuses');
    }
};
