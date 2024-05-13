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
        Schema::create('finished_goods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('finished_goods_category_id');
            $table->string('name', 255)->index();
            $table->string('code', 255)->nullable()->index();
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();

            /*qty info*/
            $table->unsignedInteger('total_finished_qty')->default(0);
            $table->unsignedInteger('total_sale_qty')->default(0);
            $table->unsignedInteger('total_returned_qty')->default(0);
            $table->unsignedInteger('total_damage_qty')->default(0);
            $table->unsignedInteger('available_qty')->default(0);

            /*material info*/
            $table->string('working_temperature', 64)->nullable();
            $table->string('length', 64)->nullable();
            $table->string('width', 64)->nullable();
            $table->string('thickness', 64)->nullable();
            $table->string('remarks', 255)->nullable();

            /*warehouse info*/
            $table->unsignedBigInteger('warehouse_id')->nullable();

            $table->text('comments')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('finished_goods_category_id')->references('id')->on('finished_goods_categories');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('finished_goods');
    }
};
