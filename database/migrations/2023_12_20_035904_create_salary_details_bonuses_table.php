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
        Schema::create('salary_details_bonuses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('salary_id');
            $table->unsignedBigInteger('salary_details_id');
            $table->unsignedBigInteger('salary_bonus_type_id');
            $table->unsignedBigInteger('settings_bonus_type_id');
            $table->unsignedBigInteger('settings_bonus_type_salary_bonus_id');

            $table->unsignedTinyInteger('bonus_rate_type')->default(0)->comment('0=percent,1=fixed_amount');
            $table->unsignedTinyInteger('bonus_salary_type')->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('bonus_rate', 10, 2)->default(0)->comment('percentage or fixed amount');
            $table->decimal('bonus_amount', 12, 2)->default(0)->comment('amount of bonus');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('salary_id')->references('id')->on('salaries');
            $table->foreign('salary_details_id')->references('id')->on('salary_details');
            $table->foreign('settings_bonus_type_id')->references('id')->on('settings_bonus_types');
            $table->foreign('settings_bonus_type_salary_bonus_id', 'sdb_sbtsb_id_foreign')->references('id')->on('settings_bonus_type_salary_bonuses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_details_bonuses');
    }
};
