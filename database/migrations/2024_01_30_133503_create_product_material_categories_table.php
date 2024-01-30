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
        Schema::create('product_material_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->text('description')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_material_categories');
    }
};
