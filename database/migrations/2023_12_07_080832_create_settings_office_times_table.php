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
        Schema::create('settings_office_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('office_time_type_id');
            $table->string('day', 16)->comment('saturday, sunday, monday, tuesday, wednesday, thursday, friday');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->boolean('is_weekend')->default(0)->comment('0: No, 1: Yes');
            $table->unsignedSmallInteger('working_hour')->default(0);

            //define relationships
            $table->foreign('office_time_type_id')->references('id')->on('settings_office_time_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings_office_times');
    }
};
