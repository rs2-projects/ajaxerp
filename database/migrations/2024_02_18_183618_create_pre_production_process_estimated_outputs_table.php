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
        Schema::create('pre_production_process_estimated_outputs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_process_id');
            $table->string('name', 255);
            $table->string('unit', 255)->nullable();
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('pre_production_id', 'pppeo_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_process_id', 'pppeo_ppp_id')->references('id')->on('pre_production_processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_process_estimated_outputs');
    }
};
