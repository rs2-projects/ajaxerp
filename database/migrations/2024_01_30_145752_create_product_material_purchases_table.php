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
        Schema::create('product_material_purchases', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('purchase_create_type')->default(0)->comment('0=new,1=from revised,2=from backed');
            $table->unsignedBigInteger('purchase_create_prev_id')->nullable();

            $table->unsignedBigInteger('supplier_id')->index();
            $table->string('purchase_id', 64)->nullable()->comment('auto generated');
            $table->string('batch_number', 64)->nullable();
            $table->date('purchase_date')->nullable();
            $table->date('estimated_delivery_date')->nullable();

            $table->decimal('subtotal_amount', 12, 2)->default(0);
            $table->decimal('total_vat_amount', 10, 2)->default(0);
            $table->unsignedTinyInteger('discount_type')->default(0)->comment('0=percent,1=fixed_amount');
            $table->decimal('discount_value', 10, 2)->default(0);
            $table->decimal('total_discount_amount', 12, 2)->default(0);
            $table->decimal('payable_amount', 12, 2)->default(0);
            $table->decimal('paid_amount', 12, 2)->default(0);
            $table->decimal('due_amount', 12, 2)->default(0);
            $table->unsignedTinyInteger('payment_status')->default(0)->comment('0=unpaid,1=partial_paid,2=paid');

            $table->unsignedSmallInteger('purchase_status')->default(0)->comment('0=new,1=on process,2=delivered,3=revised or backed');
            $table->unsignedTinyInteger('has_damage')->default(0)->comment('0=no,1=yes');
            $table->unsignedTinyInteger('has_missing')->default(0)->comment('0=no,1=yes');

            $table->unsignedTinyInteger('is_revised')->default(0)->comment('0=no,1=yes');
            $table->unsignedBigInteger('revised_by')->nullable();
            $table->timestamp('revised_at')->nullable();
            $table->unsignedTinyInteger('is_backed')->default(0)->comment('0=no,1=yes');
            $table->unsignedBigInteger('backed_by')->nullable();
            $table->timestamp('backed_at')->nullable();

            $table->text('notes')->nullable();
            $table->text('invoice_footer')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('supplier_id')->references('id')->on('suppliers');
            $table->foreign('revised_by')->references('id')->on('users');
            $table->foreign('backed_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_purchases');
    }
};
