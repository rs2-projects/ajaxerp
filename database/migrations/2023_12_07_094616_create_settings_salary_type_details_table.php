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
        Schema::create('settings_salary_type_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('settings_salary_type_id');
            $table->unsignedTinyInteger('type')->default(0)->comment('0=earning/allowance,1=deduction');
            $table->string('title', 255);
            $table->decimal('value',6,2)->default(0)->comment('percentage of basic salary');

            //define relationships
            $table->foreign('settings_salary_type_id')->references('id')->on('settings_salary_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_salary_type_details');
    }
};
