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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('transaction_id', 32)->index()->comment('auto generated unique transaction id');
            $table->unsignedTinyInteger('paid_type')->comment('0=unpaid, 1=paid');
            $table->unsignedTinyInteger('transaction_type')->index()->comment('0=deposit,1=withdraw');
            $table->date('transaction_date')->index()->comment('transaction date');
            $table->unsignedBigInteger('account_id')->comment('id from acc_coa_accounts table');
            $table->unsignedBigInteger('category_id')->nullable()->comment('id from acc_coa_accounts table');
            $table->unsignedSmallInteger('reference_type')->comment('0=income,1=expense,2=transfer,3=assetProductPurchase,4=productMaterialPurchase,5=assetProductPurchasePayment,6=productMaterialPurchasePayment');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('id from respective table');
            $table->string('reference_description', 255)->nullable()->comment('description of reference');

            $table->decimal('total_cost_price', 12, 2)->default(0)->comment('total cost price only for sales');
            $table->decimal('net_amount', 12, 2)->default(0)->comment('amount without vat');
            $table->decimal('total_vat_amount', 12, 2)->default(0)->comment('vat amount');
            $table->decimal('total_amount', 12, 2)->default(0)->comment('total amount with vat');
            $table->text('description')->nullable()->comment('transaction description');
            $table->text('note')->nullable()->comment('transaction note');
            $table->boolean('is_reviewed')->default(0)->comment('0=not reviewed, 1=reviewed');
            $table->timestamp('reviewed_at')->nullable();
            $table->unsignedBigInteger('reviewed_by')->nullable()->comment('id from users table');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('account_id')->references('id')->on('acc_coa_accounts');
            $table->foreign('category_id')->references('id')->on('acc_coa_accounts');
            $table->foreign('reviewed_by')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
