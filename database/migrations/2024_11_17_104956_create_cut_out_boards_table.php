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
        Schema::create('cut_out_boards', function (Blueprint $table) {
            $table->id();

            $table->string('name', 128);
            $table->string('description', 255)->nullable();
            $table->unsignedInteger('available_qty')->default(0);
            $table->unsignedInteger('used_qty')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
            $table->boolean('synced')->default(false); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cut_out_boards');
    }
};
