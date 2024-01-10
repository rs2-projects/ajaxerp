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
        Schema::table('user_leaves', function (Blueprint $table) {
            $table->date('paid_leave_start_date')->nullable()->after('approved_number_of_days');
            $table->date('paid_leave_end_date')->nullable()->after('paid_leave_start_date');
            $table->integer('paid_leave_number_of_days')->nullable()->after('paid_leave_end_date');
            $table->date('unpaid_leave_start_date')->nullable()->after('paid_leave_number_of_days');
            $table->date('unpaid_leave_end_date')->nullable()->after('unpaid_leave_start_date');
            $table->integer('unpaid_leave_number_of_days')->nullable()->after('unpaid_leave_end_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_leaves', function (Blueprint $table) {
            $table->dropColumn('paid_leave_start_date');
            $table->dropColumn('paid_leave_end_date');
            $table->dropColumn('paid_leave_number_of_days');
            $table->dropColumn('unpaid_leave_start_date');
            $table->dropColumn('unpaid_leave_end_date');
            $table->dropColumn('unpaid_leave_number_of_days');
        });
    }
};
