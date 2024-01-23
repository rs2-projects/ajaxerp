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
        Schema::table('settings_leave_types', function (Blueprint $table) {
            $table->unsignedTinyInteger('salary_type')->default(0)->after('max_leave_per_month')->comment('0=basic_salary,1=gross_salary');
            $table->decimal('rate', 6, 2)->default(0)->after('salary_type')->comment('percentage of basic salary');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings_leave_types', function (Blueprint $table) {
            $table->dropColumn('salary_type');
            $table->dropColumn('rate');
        });
    }
};
