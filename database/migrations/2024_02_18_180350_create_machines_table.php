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
        Schema::create('machines', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('image', 255)->nullable();
            $table->string('model', 255)->nullable();
            $table->string('color', 255)->nullable();
            $table->text('description')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('machines');
        Schema::enableForeignKeyConstraints();
    }
};
