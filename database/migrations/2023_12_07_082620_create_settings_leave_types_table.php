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
        Schema::create('settings_leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->index();
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('annual_leave_days')->default(0);
            $table->unsignedSmallInteger('max_leave_per_month')->default(0);
            $table->unsignedTinyInteger('salary_type')->default(0)->comment('0=basic_salary,1=gross_salary');
            $table->decimal('rate', 6, 2)->default(0)->comment('percentage of basic salary');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_leave_types');
    }
};
