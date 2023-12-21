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
        Schema::create('user_education_infos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('degree',128)->nullable();
            $table->string('institute_name',128)->nullable();
            $table->string('subject',128)->nullable();
            $table->string('grade',128)->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationship
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_education_infos');
    }
};
