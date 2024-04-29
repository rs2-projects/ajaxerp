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
        Schema::create('asset_product_assigns', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->string('sl_no', 128)->nullable()->index();
            $table->string('model', 128)->nullable();
            $table->unsignedBigInteger('asset_product_id');
            $table->unsignedInteger('qty')->default(1);
            $table->unsignedBigInteger('employee_id')->nullable();
            $table->unsignedSmallInteger('assign_status')->default(1)
                ->comment('1=Assigned,2=In Maintenance,3=Sold,4=Disposed,5=Repaired,6=Returned');
            $table->text('reason')->nullable();
            $table->text('remarks')->nullable();
            $table->date('warranty')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign keys
            $table->foreign('asset_product_id')->references('id')->on('asset_products');
            $table->foreign('employee_id')->references('id')->on('users');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_assigns');
    }
};
