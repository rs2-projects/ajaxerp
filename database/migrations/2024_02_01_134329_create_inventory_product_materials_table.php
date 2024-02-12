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
        Schema::create('inventory_product_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_category_id');
            $table->unsignedBigInteger('product_material_id')->index();
            $table->unsignedTinyInteger('type')->default(0)->comment('0=in,1=out');
            $table->unsignedTinyInteger('reference_type')->default(0)->comment('0=product_material_purchase,1=product_material_use etc');
            $table->unsignedBigInteger('reference_id')->nullable()->comment('if reference_type=0 then id from product_material_purchases_details table else id from respective table');
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('product_material_category_id','ipm_pmc_id_foreign')->references('id')->on('product_material_categories');
            $table->foreign('product_material_id','ipm_pm_id_foreign')->references('id')->on('product_materials');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::dropIfExists('inventory_product_materials');
    }
};
