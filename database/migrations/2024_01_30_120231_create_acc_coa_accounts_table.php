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
        Schema::create('acc_coa_accounts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acc_coa_category_id');
            $table->unsignedBigInteger('acc_coa_sub_category_id');
            $table->string('name', 255)->index();
            $table->string('slug', 255)->nullable();
            $table->string('account_no', 255)->nullable();
            $table->text('description')->nullable();
            $table->decimal('tax_rate', 8, 2)->default(0.00);
            $table->decimal('opening_balance', 12, 2)->default(0.00);
            $table->decimal('available_balance', 12, 2)->default(0.00);
            $table->boolean('can_edit')->default(0)->comment('0=No,1=Yes');
            $table->boolean('is_default')->default(0)->comment('0=No,1=Yes');

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('acc_coa_category_id')->references('id')->on('acc_coa_categories');
            $table->foreign('acc_coa_sub_category_id')->references('id')->on('acc_coa_sub_categories');

            $table->comment('Accounting -> Chart of Account Accounts');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('acc_coa_accounts');
    }
};
