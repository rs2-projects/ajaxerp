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
        Schema::create('board_pre_productions', function (Blueprint $table) {
            $table->id();
            $table->string('pre_production_no', 64)->index('bpp_pre_production_no_index')->nullable();
            $table->unsignedBigInteger('finished_goods_id')->index('bpp_finished_goods_id_index');
            $table->unsignedInteger('estimated_quantity')->default(0);
            $table->unsignedBigInteger('machine_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();
            $table->text('note');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('finished_goods_id', 'bpp_finished_goods_id_foreign')->references('id')->on('finished_goods');
            $table->foreign('machine_id', 'bpp_machine_id_foreign')->references('id')->on('machines');
            $table->foreign('staff_id', 'bpp_staff_id_foreign')->references('id')->on('production_staff');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_pre_productions');
    }
};
