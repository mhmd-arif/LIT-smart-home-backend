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
            $table->unsignedBigInteger('user_device_id');
            $table->unsignedBigInteger('user_id');
            $table->float('watt')->nullable()->default(0);
            // $table->float('total_watt', 9, 5)->nullable()->default(0.0000);
            $table->decimal('kwh', 9, 5)->nullable()->default(0.0000);
            $table->boolean('state');
            $table->dateTime('created_at');
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
