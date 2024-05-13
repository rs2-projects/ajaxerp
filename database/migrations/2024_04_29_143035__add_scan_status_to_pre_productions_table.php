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
            $table->unsignedSmallInteger('scan_status')->default(0)->after('received_status')->comment('0=Pending, 1=Scanned, 2=Partially Scanned');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pre_productions', function (Blueprint $table) {
            $table->dropColumn('scan_status');
        });
    }
};
