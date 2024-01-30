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
        Schema::create('asset_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_product_category_id')->nullable();

            $table->string('name', 255)->index();
            $table->string('image', 255)->nullable();
            $table->text('description')->nullable();
            $table->text('comments')->nullable();

            /*qty*/
            $table->unsignedInteger('total_purchased_qty')->default(0);
            $table->unsignedInteger('total_returned_qty')->default(0);
            $table->unsignedInteger('total_damage_qty')->default(0);
            $table->unsignedInteger('available_qty')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('asset_product_category_id')->references('id')->on('asset_product_categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_products');
    }
};
