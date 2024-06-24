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
        if (!Schema::hasColumn('acc_coa_accounts', 'synced')) {
            Schema::table('acc_coa_accounts', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }
        if (!Schema::hasColumn('acc_coa_categories', 'synced')) {
            Schema::table('acc_coa_categories', function (Blueprint $table) {
                $table->boolean('synced')->default(false);
            });
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
    }
};
