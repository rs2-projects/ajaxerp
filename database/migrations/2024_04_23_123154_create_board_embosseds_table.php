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
        Schema::create('board_embosseds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->index();
            $table->string('image', 255)->nullable()->default(null);
            $table->string('code', 128)->nullable()->default(null);
            $table->text('note')->nullable()->default(null);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('board_embosseds');
    }
};
