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
        Schema::create('device_usages', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('device_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('kwh');
            $table->string('status');
            $table->dateTime('created_at');
            // $table->dateTime('created_at')->nullable()->default(new DateTime());
        });
    }

    /**
     * Reverse the migrations.x
     */
    public function down(): void
    {
        Schema::dropIfExists('device_usages');
    }
};
