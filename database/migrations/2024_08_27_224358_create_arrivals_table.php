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
        Schema::create('arrivals', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedTinyInteger('rt');
            $table->string('nik');
            $table->string('name');
            $table->string('phone');
            $table->string('old_address');
            $table->string('home_owner');
            $table->string('home_address');
            $table->boolean('is_married')->default(false);
            $table->string('foto_ktp')->nullable();
            $table->string('foto_kk')->nullable();
            $table->string('foto_bukunikah')->nullable();
            $table->boolean('is_valid')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('arrivals');
    }
};
