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
        Schema::table('pre_productions', function (Blueprint $table) {
            $table->string('pre_production_batch_no')->after('pre_production_no')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_productions', function (Blueprint $table) {
            $table->dropColumn('pre_production_batch_no');
        });
    }
};
