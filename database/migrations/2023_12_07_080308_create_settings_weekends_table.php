<?php

use App\Helpers\Development\MigrationHelper;
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
        Schema::create('settings_weekends', function (Blueprint $table) {
            $table->id();
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->boolean('saturday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('sunday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('monday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('tuesday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('wednesday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('thursday')->default(0)->comment('0: No, 1: Yes');
            $table->boolean('friday')->default(0)->comment('0: No, 1: Yes');

            MigrationHelper::getCommonColumns($table);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_weekends');
    }
};
