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
        Schema::create('pre_production_process_machines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('pre_production_process_id');
            $table->unsignedBigInteger('machine_id');

            //define foreign keys
            $table->foreign('pre_production_id', 'ppp_machine_pp_id')->references('id')->on('pre_productions');
            $table->foreign('pre_production_process_id', 'ppp_machine_ppp_id')->references('id')->on('pre_production_processes');
            $table->foreign('machine_id', 'ppp_machine_machine_id')->references('id')->on('machines');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_process_machines');
    }
};
