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
        Schema::create('asset_product_purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_product_purchase_order_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedSmallInteger('payment_method')->comment('1=Bank Payment, 2=Cash, 3=Cheque, 4=Credit Card, 5=Paypal, 6=Others');
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->string('note', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('asset_product_purchase_order_id','appp_appo_id')->references('id')->on('asset_product_purchase_orders');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_purchase_payments');
    }
};
