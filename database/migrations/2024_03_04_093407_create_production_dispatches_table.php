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
        Schema::create('production_dispatches', function (Blueprint $table) {
            $table->id();
            $table->string('dispatch_no', 50)->comment('Dispatch Number should be unique and auto generated');
            $table->string('pre_production_no', 50)->nullable()->comment('from pre_productions table. for barcode');
            $table->unsignedBigInteger('pre_production_id');
            $table->unsignedBigInteger('finished_goods_id');
            $table->unsignedInteger('dispatched_qty')->default(0);
            $table->unsignedInteger('received_qty')->default(0);
            $table->unsignedBigInteger('dispatched_by');
            $table->timestamp('dispatched_at')->nullable();
            $table->unsignedBigInteger('received_by')->nullable();
            $table->timestamp('received_at')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('pre_production_id')->references('id')->on('pre_productions');
            $table->foreign('finished_goods_id')->references('id')->on('finished_goods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_dispatches');
    }
};
