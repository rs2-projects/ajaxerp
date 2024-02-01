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
        Schema::create('asset_product_purchase_requests', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255)->index();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('requested_by');

            $table->unsignedSmallInteger('request_status')->default(0)->comment('0=new,1=approved,2=declined,3=requested additional info,4=info submitted');

            $table->text('additional_info')->nullable();

            \App\Helpers\Development\MigrationHelper::getCommonColumns($table);

            //define foreign key
            $table->foreign('requested_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_purchase_requests');
    }
};
