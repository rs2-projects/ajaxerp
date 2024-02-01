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
        Schema::create('product_material_purchase_detail_damage_files', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_material_purchase_id');
            $table->unsignedBigInteger('product_material_purchase_detail_id')->index('pmpddf_pmpd_id_index');
            $table->unsignedTinyInteger('file_type')->default(0)->comment('0=damage,1=missing');
            $table->string('file_path', 255)->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('product_material_purchase_id', 'pmpddf_pmp_id_foreign')->references('id')->on('product_material_purchases');
            $table->foreign('product_material_purchase_detail_id', 'pmpddf_pmpd_id_foreign')->references('id')->on('product_material_purchase_details');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_purchase_detail_damage_files');
    }
};
