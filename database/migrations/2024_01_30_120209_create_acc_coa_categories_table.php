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
        Schema::create('acc_coa_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->unsignedSmallInteger('type')->default(0)->comment('0=Assets,1=Liabilities & Credit Cards,2=Income,3=Expenses,4=Equity');
            $table->text('description')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            $table->comment('Accounting -> Chart of Account Categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_coa_categories');
    }
};
