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
        Schema::create('product_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_category_id');
            $table->unsignedBigInteger('tax_id')->nullable();
            $table->unsignedSmallInteger('unit_type')->default(1)->comment('1=box,2=cm,3=dz,4=ft,5=g,6=in,7=kg,8=km,9=lb,10=mg,11=ml,12=m,13=pcs,14=set,15=yd');
            $table->string('name', 255)->index();
            $table->string('code', 255)->nullable()->index();
            $table->string('image', 255)->nullable();
            $table->unsignedInteger('low_stock_warning')->default(0);
            $table->unsignedInteger('low_stock_at_least')->default(0);
            $table->text('description')->nullable();

            /*qty info*/
            $table->unsignedInteger('total_purchased_qty')->default(0);
            $table->unsignedInteger('total_used_qty')->default(0);
            $table->unsignedInteger('total_returned_qty')->default(0);
            $table->unsignedInteger('total_damage_qty')->default(0);
            $table->unsignedInteger('available_qty')->default(0);

            /*material info*/
            $table->string('color', 64)->nullable();
            $table->string('working_temperature', 64)->nullable();
            $table->string('length', 64)->nullable();
            $table->string('width', 64)->nullable();
            $table->string('thickness', 64)->nullable();
            $table->string('remarks', 255)->nullable();

            /*warehouse info*/
            $table->unsignedBigInteger('warehouse_id')->nullable();
            $table->unsignedBigInteger('warehouse_section_id')->nullable();
            $table->unsignedBigInteger('warehouse_section_rack_id')->nullable();

            $table->text('comments')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('product_material_category_id')->references('id')->on('product_material_categories');
            $table->foreign('tax_id')->references('id')->on('acc_coa_accounts');
            $table->foreign('warehouse_id')->references('id')->on('warehouses');
            $table->foreign('warehouse_section_id')->references('id')->on('warehouse_sections');
            $table->foreign('warehouse_section_rack_id')->references('id')->on('warehouse_section_racks');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_materials');
    }
};
