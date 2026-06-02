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
        Schema::table('invoice_details', function (Blueprint $table) {
            if (!Schema::hasColumn('invoice_details', 'item_name')) {
                $table->string('item_name', 255)->nullable()->after('item_id');
            }

            if (!Schema::hasColumn('invoice_details', 'unit')) {
                $table->string('unit', 50)->nullable()->after('description');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('invoice_details', function (Blueprint $table) {
            $columns = [];

            if (Schema::hasColumn('invoice_details', 'item_name')) {
                $columns[] = 'item_name';
            }

            if (Schema::hasColumn('invoice_details', 'unit')) {
                $columns[] = 'unit';
            }

            if (!empty($columns)) {
                $table->dropColumn($columns);
            }
        });
    }
};
