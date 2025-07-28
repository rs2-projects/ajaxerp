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
        Schema::create('product_material_stocks', function (Blueprint $table) {
            $table->id();
            $table->date('date')->nullable()->index();
            $table->unsignedBigInteger('product_material_category_id');
            $table->unsignedBigInteger('product_material_id')->index();
            $table->unsignedTinyInteger('product_material_type')->default(0)->comment('0=others,1=boards, 2=paper');
            $table->unsignedTinyInteger('type')->default(0)->comment('0=in,1=out');
            $table->unsignedTinyInteger('reference_type')->default(0)->comment('0=initial_stock,1=purchase,2=sales,3=use,4=return,5=damage etc');
            $table->unsignedBigInteger('reference_id')->nullable();
            $table->unsignedInteger('quantity')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_stocks');
    }
};
