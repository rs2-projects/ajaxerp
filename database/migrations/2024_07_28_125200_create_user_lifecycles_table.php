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
        Schema::create('user_lifecycles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedInteger('type')->default(1)
                ->comment('
                0=Join,
                1=Promotion,
                2=Demotion,
                3=Salary Update,
                4=Termination,
                5=Resignation Requested,
                6=Resignation Rejected,
                7=Resignation Approved
                ');
            $table->date('date');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('designation_id')->nullable();
            $table->decimal('basic_salary', 12, 2)->default(0);
            $table->text('reference_description')->nullable();
            $table->text('description')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_lifecycles');
    }
};
