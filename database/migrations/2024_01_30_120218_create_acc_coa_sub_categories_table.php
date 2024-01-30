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
        Schema::create('acc_coa_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acc_coa_category_id');
            $table->string('name', 255);
            $table->string('slug', 255)->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_account_type')->default(0)->comment('0=No,1=Yes');
            $table->boolean('can_create_account')->default(0)->comment('0=Can\'t Create,1=Can Create');
            $table->boolean('is_sales_tax')->default(0)->comment('0=No,1=Yes');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('acc_coa_category_id')->references('id')->on('acc_coa_categories');

            $table->comment('Accounting -> Chart of Account Sub Categories');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_coa_sub_categories');
    }
};
