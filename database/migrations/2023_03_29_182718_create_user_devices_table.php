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
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('device_name', 100)->default('device_name');
            $table->string('category', 100)->nullable()->default('category');
            $table->boolean('is_favorite')->nullable()->default(false);
            $table->float('volt')->nullable()->default(0);
            $table->float('ampere')->nullable()->default(0);
            $table->float('watt')->nullable()->default(0);
            $table->boolean('state')->nullable()->default(false);
            $table->decimal('last_kwh', 9, 5)->nullable()->default(0.0000);
            $table->string('icon_url', 100)->nullable()->default('mdi-devices');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};