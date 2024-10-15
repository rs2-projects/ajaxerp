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
        Schema::create('newer_picked_product_histories', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('product_material_id');
            $table->unsignedBigInteger('product_material_purchase_details_id');
            $table->unsignedBigInteger('pre_production_material_delivery_details_id');
            $table->timestamp('picked_at')->nullable();
            $table->unsignedSmallInteger('action_status')->default(0)->comment('0=Not Viewed, 1=Viewed, 2=Action Done');

            App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('newer_picked_product_histories');
    }
};
