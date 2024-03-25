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
        Schema::create('transaction_vats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transaction_id');
            $table->unsignedBigInteger('tax_id');
            $table->decimal('main_amount', 12,2);
            $table->decimal('vat_percent', 12,2)->default(0);
            $table->decimal('vat_amount', 12,2)->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('transaction_id')->references('id')->on('transactions');
            $table->foreign('tax_id')->references('tax_id')->on('acc_coa_accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_vats');
    }
};
