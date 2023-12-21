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
        Schema::create('user_emergency_contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name', 255)->index();
            $table->string('email', 128)->nullable();
            $table->string('phone', 32)->nullable();
            $table->string('relation', 128)->index();
            $table->unsignedTinyInteger('status')->default(1)->comment('0=inactive,1=active');

            //define relationships
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_emergency_contacts');
    }
};
