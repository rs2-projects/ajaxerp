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
        Schema::table('settings_office_time_types', function (Blueprint $table) {
            $table->unsignedSmallInteger('working_hour')->default(0)->after('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('settings_office_time_types', function (Blueprint $table) {
            $table->dropColumn('working_hour');
        });
    }
};
