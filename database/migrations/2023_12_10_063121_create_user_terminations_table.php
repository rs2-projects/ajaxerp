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
        Schema::create('user_terminations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('settings_termination_type_id');
            $table->date('notice_date');
            $table->date('termination_date');
            $table->text('reason');
            $table->text('remarks')->nullable();
            $table->unsignedTinyInteger('termination_status')->default(0)->comment('0: Pending, 1: Approved, 2: Rejected');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define relationships
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('settings_termination_type_id')->references('id')->on('settings_termination_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_terminations');
    }
};
