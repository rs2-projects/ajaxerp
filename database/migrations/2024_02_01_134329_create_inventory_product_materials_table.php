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
        //TODO:: need to implement by oalid
        //note by oalid: skipp this table for now. will be implemented later
        /*Schema::create('inventory_product_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_category_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedTinyInteger('type')->default(0)->comment('0=in,1=out');

        });*/
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
//        Schema::dropIfExists('inventory_product_materials');
    }
};
