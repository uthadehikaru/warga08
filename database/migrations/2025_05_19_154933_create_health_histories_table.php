<?php

use App\Models\HealthRecord;
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
        Schema::create('health_histories', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->foreignIdFor(HealthRecord::class);
            $table->date('check_date');
            $table->unsignedInteger('height')->nullable();
            $table->unsignedInteger('weight')->nullable();
            $table->string('imt')->nullable();
            $table->unsignedInteger('lingkar_perut')->nullable();
            $table->unsignedInteger('sistol')->nullable();
            $table->unsignedInteger('diastol')->nullable();
            $table->string('tekanan_darah')->nullable();
            $table->string('gula_darah')->nullable();
            $table->unsignedInteger('kadar_hb')->nullable();
            $table->string('anemia')->nullable();
            $table->boolean('batuk')->default(false);
            $table->boolean('demam')->default(false);
            $table->boolean('bb_stagnan')->default(false);
            $table->boolean('kontak_tbc')->default(false);
            $table->boolean('masalah_di_rumah')->default(false);
            $table->boolean('masalah_di_instansi')->default(false);
            $table->boolean('masalah_pola_makan')->default(false);
            $table->boolean('masalah_aktivitas')->default(false);
            $table->boolean('masalah_obat')->default(false);
            $table->boolean('masalah_seksual')->default(false);
            $table->boolean('masalah_keamanan')->default(false);
            $table->boolean('masalah_depresi')->default(false);
            $table->text('edukasi')->nullable();
            $table->boolean('rujuk')->default(false);
            $table->unsignedTinyInteger('step')->default(1);
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('health_histories');
    }
};
