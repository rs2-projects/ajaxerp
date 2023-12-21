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
        Schema::create('settings_salary_set_leave_types', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_salary_set_id');
            $table->unsignedBigInteger('settings_leave_type_id');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('settings_salary_set_id')->references('id')->on('settings_salary_sets');
            $table->foreign('settings_leave_type_id')->references('id')->on('settings_leave_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_set_leave_types');
    }
};
