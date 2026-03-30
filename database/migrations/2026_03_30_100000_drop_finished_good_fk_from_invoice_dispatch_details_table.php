<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $database = DB::getDatabaseName();
        $hasConstraint = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', 'invoice_dispatch_details')
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->where('CONSTRAINT_NAME', 'idd_finished_good_id')
            ->exists();

        if ($hasConstraint) {
            DB::statement('ALTER TABLE `invoice_dispatch_details` DROP FOREIGN KEY `idd_finished_good_id`');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $database = DB::getDatabaseName();
        $hasConstraint = DB::table('information_schema.TABLE_CONSTRAINTS')
            ->where('TABLE_SCHEMA', $database)
            ->where('TABLE_NAME', 'invoice_dispatch_details')
            ->where('CONSTRAINT_TYPE', 'FOREIGN KEY')
            ->where('CONSTRAINT_NAME', 'idd_finished_good_id')
            ->exists();

        if (!$hasConstraint) {
            DB::statement('ALTER TABLE `invoice_dispatch_details` ADD CONSTRAINT `idd_finished_good_id` FOREIGN KEY (`finished_good_id`) REFERENCES `finished_goods`(`id`)');
        }
    }
};

