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
        Schema::create('invoice_dispatch_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_dispatch_id')->index();
            $table->unsignedBigInteger('invoice_detail_id');
            $table->unsignedBigInteger('finished_good_id');
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('invoice_dispatch_id','idd_invoice_dispatch_id')->references('id')->on('invoice_dispatches');
            $table->foreign('invoice_detail_id', 'idd_invoice_detail_id')->references('id')->on('invoice_details');
            $table->foreign('finished_good_id', 'idd_finished_good_id')->references('id')->on('finished_goods');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_dispatch_details');
    }
};
