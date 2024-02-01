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
        Schema::create('product_material_purchase_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_purchase_id')->index('pmpd_pmp_id_index');
            $table->unsignedBigInteger('product_material_id');
            $table->text('description')->nullable();
            $table->string('color', 64)->nullable();

            $table->unsignedInteger('qty')->default(0);
            $table->decimal('unit_price', 12, 2)->default(0);
            $table->decimal('total_price', 12, 2)->default(0)->comment('qty * unit_price');

            $table->unsignedBigInteger('tax_id')->nullable();
            $table->decimal('tax_rate', 10, 2)->default(0);
            $table->decimal('tax_amount', 12, 2)->default(0);

            $table->decimal('net_total', 12, 2)->default(0)->comment('total_price + tax_amount');

            $table->unsignedTinyInteger('is_perfect')->default(0)->comment('0=no,1=yes');
            $table->unsignedTinyInteger('has_damage')->default(0)->comment('0=no,1=yes');
            $table->unsignedInteger('damage_qty')->default(0);
            $table->string('damage_remarks', 255)->nullable();
            $table->unsignedTinyInteger('has_missing')->default(0)->comment('0=no,1=yes');
            $table->unsignedInteger('missing_qty')->default(0);
            $table->string('missing_remarks', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('product_material_purchase_id', 'pmpd_pmp_id_foreign')->references('id')->on('product_material_purchases');
            $table->foreign('product_material_id', 'pmpd_pm_id_foreign')->references('id')->on('product_materials');
            $table->foreign('tax_id')->references('id')->on('acc_coa_accounts');



        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_purchase_details');
    }
};
