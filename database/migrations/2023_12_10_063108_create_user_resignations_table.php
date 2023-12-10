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
        Schema::create('user_resignations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->date('notice_date');
            $table->date('resignation_date');
            $table->text('reason');
            $table->text('remarks')->nullable();
            $table->unsignedTinyInteger('resignation_status')->default(0)->comment('0: Pending, 1: Approved, 2: Rejected');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_resignations');
    }
};
