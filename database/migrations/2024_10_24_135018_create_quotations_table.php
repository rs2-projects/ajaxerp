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
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();
            $table->string('quotation_no', 64)->nullable()->index()->comment('Quotation Number should be unique and auto generated');
            $table->unsignedBigInteger('customer_id')->index();
            $table->string('ref_no', 128)->nullable()->comment('input from user (Quotation Ref No)');
            $table->date('quotation_date')->nullable();
            $table->string('project_name', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('subtotal_amount', 16, 6)->default(0);
            $table->decimal('vat_amount', 16, 6)->default(0);
            $table->decimal('total_amount', 16, 6)->default(0);
            $table->unsignedTinyInteger('discount_type')->default(0)->comment('0=Percentage, 1=Fixed');
            $table->decimal('discount_value', 16, 6)->default(0);
            $table->decimal('discount_amount', 16, 6)->default(0);
            $table->decimal('unloading_cost', 16, 6)->default(0);
            $table->decimal('first_down_payment_percent', 16, 6)->default(0);
            $table->decimal('payable_amount', 16, 6)->default(0);

            $table->unsignedTinyInteger('quotation_status')->default(0)->comment('0=pending,1=processing,2=cancelled,3=invoice created');
            $table->unsignedBigInteger('cancelled_by')->nullable();
            $table->timestamp('cancelled_at')->nullable();
            $table->text('notes')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false);

            //define foreign keys
            $table->foreign('customer_id')->references('id')->on('customers');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
