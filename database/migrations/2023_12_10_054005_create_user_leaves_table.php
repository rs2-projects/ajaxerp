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
        Schema::create('user_leaves', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('settings_leave_type_id');
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('number_of_days')->default(0);
            $table->text('reason')->nullable();
            $table->unsignedTinyInteger('leave_status')->default(0)->comment('	0=Pending,1=Accepted,2=Rejected');
            $table->timestamp('accepted_at')->nullable();
            $table->unsignedBigInteger('accepted_by')->nullable();
            $table->date('approve_start_date')->nullable();
            $table->date('approve_end_date')->nullable();
            $table->integer('approved_number_of_days')->nullable();
            $table->timestamp('rejected_at')->nullable();
            $table->unsignedBigInteger('rejected_by')->nullable();
            $table->text('reject_reason')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leaves');
    }
};
