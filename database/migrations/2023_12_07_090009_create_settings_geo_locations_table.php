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
        Schema::create('settings_geo_locations', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->index();
            $table->text('description')->nullable();
            $table->unsignedTinyInteger('map_type')->default(0)->comment('0=polygon, 1=circle, 2=rectangle');
            $table->text('location_data')->nullable();
            $table->boolean('is_default')->default(0);

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_geo_locations');
    }
};
