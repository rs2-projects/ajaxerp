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
        Schema::create('user_leave_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('settings_leave_type_id')->nullable();
            $table->unsignedBigInteger('user_leave_id')->nullable();
            $table->date('date')->nullable();
            $table->unsignedTinyInteger('day_type')->default(0)->comment('0=general, 1=weekend, 2=holiday');
            $table->boolean('is_paid')->default(false)->comment('0=unpaid, 1=paid');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            // define foreign keys
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('settings_leave_type_id')->references('id')->on('settings_leave_types');
            $table->foreign('user_leave_id')->references('id')->on('user_leaves');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_leave_details');
    }
};
