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
        Schema::table('pre_production_process_estimated_outputs', function (Blueprint $table) {
            $table->unsignedInteger('verified_qty')->after('quantity')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_production_process_estimated_outputs', function (Blueprint $table) {
            $table->dropColumn('verified_qty');
        });
    }
};
