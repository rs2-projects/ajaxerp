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
        Schema::create('product_material_purchase_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_purchase_id');
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('account_id');
            $table->unsignedSmallInteger('payment_method')->comment('1=Bank Payment, 2=Cash, 3=Cheque, 4=Credit Card, 5=Paypal, 6=Others');
            $table->decimal('amount', 12, 2);
            $table->date('payment_date');
            $table->string('note', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('product_material_purchase_id','pmpp_pmp_id')->references('id')->on('product_material_purchases');
            $table->foreign('transaction_id', 'pmpp_transaction_id')->references('id')->on('transactions');
            $table->foreign('account_id', 'pmpp_account_id')->references('id')->on('acc_coa_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_purchase_payments');
    }
};
