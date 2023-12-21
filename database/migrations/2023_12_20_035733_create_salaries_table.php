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
        Schema::create('salaries', function (Blueprint $table) {
            $table->id();
            $table->integer('salary_year')->comment('Salary Year. Like: 2023');
            $table->integer('salary_month')->comment('Salary Month. Like: 12');
            $table->date('salary_date')->comment('First Day Of Generated Month. Like: 2023-12-01');

            $table->unsignedTinyInteger('salary_generate_type')->default(1)->comment('1=Half Month, 2=Full Month');
            $table->unsignedTinyInteger('salary_period')->default(1)->comment('1=1st Half, 2=2nd Half, 3=Full Month');
            $table->unsignedBigInteger('generated_by')->nullable();
            $table->timestamp('generated_at')->nullable();
            $table->unsignedTinyInteger('generation_status')->default(1)->comment('0=Running, 1=Success, 2=Error');
            $table->text('generation_error')->nullable();
            $table->date('start_date')->nullable()->comment('Salary From Date');
            $table->date('end_date')->nullable()->comment('Salary To Date');

            $table->integer('no_of_days')->nullable()->comment('Total Days');

            $table->unsignedBigInteger('settings_salary_deduction_type_id')->nullable();

            $table->decimal('total_salary_amount', 12, 2)->default(0)->comment('Total Salary Amount With Salary Addition and Deduction');
            $table->decimal('total_bonus_amount', 12, 2)->default(0)->comment('Total Bonus Amount');
            $table->decimal('total_deduction_amount', 12, 2)->default(0)->comment('Total Deduction(If Salary generate deduction selected) Amount');
            $table->decimal('total_amount_to_pay', 12, 2)->default(0);
            $table->decimal('total_amount_paid', 12, 2)->default(0);

            $table->unsignedTinyInteger('view_status')->default(1)->comment('0=Not Viewed, 1=Viewed');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('generated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salaries');
    }
};
