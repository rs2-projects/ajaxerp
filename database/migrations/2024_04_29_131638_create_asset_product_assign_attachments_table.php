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
        Schema::create('asset_product_assign_attachments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('asset_product_assign_id');
            $table->string('attachment', 128)->nullable();
            $table->unsignedTinyInteger('status')->default(1)->comment('0=Inactive,1=Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_product_assign_attachments');
    }
};
