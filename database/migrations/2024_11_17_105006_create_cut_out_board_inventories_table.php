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
        Schema::create('cut_out_board_inventories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cut_out_board_id');
            $table->string('length', 32)->nullable();
            $table->string('width', 32)->nullable();
            $table->string('thickness', 32)->nullable();
            $table->string('color', 32)->nullable();
            $table->unsignedInteger('total_qty')->default(0);
            $table->unsignedInteger('available_qty')->default(0);
            $table->unsignedInteger('used_qty')->default(0);
            $table->unsignedBigInteger('damage_pre_production_id')->nullable();
            $table->unsignedBigInteger('damage_pre_production_process_estimated_output_id')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_out_board_inventories');
    }
};
