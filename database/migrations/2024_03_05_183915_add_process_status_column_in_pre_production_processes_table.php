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
        Schema::table('pre_production_processes', function (Blueprint $table) {
            $table->unsignedTinyInteger('process_status')->after('instruction')->default(0)->comment('0=Pending, 1=Processing, 2=Completed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_processes', function (Blueprint $table) {
            $table->dropColumn('process_status');
        });
    }
};
