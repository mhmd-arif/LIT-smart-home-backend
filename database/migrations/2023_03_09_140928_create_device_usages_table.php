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
            $table->integer('kwh');
            $table->boolean('is_on');
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
