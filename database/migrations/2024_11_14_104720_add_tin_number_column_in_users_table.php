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
        Schema::table('users', function (Blueprint $table) {
            $table->string('tin_number', 32)->nullable()->after('nid_image');
            $table->string('sss_number', 32)->nullable()->after('tin_number');
            $table->string('phic', 32)->nullable()->after('sss_number');
            $table->string('pag_ibig', 32)->nullable()->after('phic');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('tin_number');
            $table->dropColumn('sss_number');
            $table->dropColumn('phic');
            $table->dropColumn('pag_ibig');
        });
    }
};
