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
        Schema::create('invoice_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('invoice_id')->index();
            $table->unsignedBigInteger('finished_good_id');
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedDecimal('unit_price', 10, 2)->default(0);
            $table->unsignedDecimal('total', 10, 2)->default(0);

            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('tax_rate', 10, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);

            $table->decimal('net_total', 12, 2)->default(0)->comment('total_price + tax_amount');

            $table->boolean('dispatched')->default(false);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('invoice_id')->references('id')->on('invoices');
            $table->foreign('finished_good_id')->references('id')->on('finished_goods');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoice_details');
    }
};
