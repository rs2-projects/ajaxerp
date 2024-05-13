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
        Schema::create('pre_productions', function (Blueprint $table) {
            $table->id();
            $table->string('pre_production_no', 50)->comment('Pre Production Number should be unique');
            $table->string('order_details', 255)->index();
            $table->string('image', 255)->nullable();
            $table->string('design_of_documents', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('finished_goods_id');
            $table->unsignedInteger('estimated_production_qty')->default(0);
            $table->text('notes')->nullable();
            $table->boolean('is_verified')->default(false)->comment('Is verified by the manager');
            $table->unsignedSmallInteger('delivery_status')->default(0)->comment('0=Pending, 1=Delivered, 2=Partially Delivered');
            $table->unsignedSmallInteger('received_status')->default(0)->comment('0=Pending, 1=Received, 2=Partially Received');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('finished_goods_id')->references('id')->on('finished_goods');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('pre_productions');
        Schema::enableForeignKeyConstraints();
    }
};
