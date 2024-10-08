<?php

use App\Models\User;
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
        Schema::create('requests', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->string('code')->unique();
            $table->string('document_no')->nullable();
            $table->string('nik');
            $table->string('name');
            $table->string('phone');
            $table->string('address');
            $table->string('email');
            $table->string('gender');
            $table->string('birth_place');
            $table->date('birth_date');
            $table->string('work');
            $table->string('religion');
            $table->string('rt_name');
            $table->string('rw_name');
            $table->text('description');
            $table->foreignIdFor(User::class);
            $table->unsignedTinyInteger('rt');
            $table->text('note')->nullable();
            $table->string('status')->default('new');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests');
    }
};
