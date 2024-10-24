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
        Schema::create('quotation_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('quotation_id')->index();
            $table->unsignedTinyInteger('item_type')->default(0)->comment('0=Raw Material, 1=Raw Board, 2=Paper, 3=Finished Goods, 4=Finished Boards, 5=Set Item, 6=Custom Item');
            $table->unsignedBigInteger('item_id')->default(0);
            $table->string('item_name', 255)->nullable();
            $table->text('description')->nullable();
            $table->unsignedInteger('quantity')->default(0);
            $table->unsignedDecimal('unit_price', 16, 6)->default(0);
            $table->unsignedDecimal('total', 16, 6)->default(0);

            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('tax_rate', 16, 6)->default(0);
            $table->decimal('tax_amount', 16, 6)->default(0);

            $table->decimal('net_total', 16, 6)->default(0)->comment('total_price + tax_amount');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('quotation_id')->references('id')->on('quotations');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotation_details');
    }
};
