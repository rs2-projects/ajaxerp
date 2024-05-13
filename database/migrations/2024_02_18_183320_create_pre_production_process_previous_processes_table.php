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
        Schema::create('pre_production_process_previous_processes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_process_id');
            $table->unsignedBigInteger('process_id');

            //define foreign keys
            $table->foreign('pre_production_id', 'ppppp_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_process_id', 'ppppp_ppp_id')->references('id')->on('pre_production_processes');
            $table->foreign('process_id', 'ppppp_process_id')->references('id')->on('pre_production_processes');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_process_previous_processes');
    }
};
