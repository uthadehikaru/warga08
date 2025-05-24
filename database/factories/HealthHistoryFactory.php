<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthHistory>
 */
class HealthHistoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'health_record_id' => 0,
            'type' => fake()->randomElement(['remaja', 'balita', 'ibu_hamil', 'lansia']),
            'check_date' => fake()->date(),
            'step' => fake()->numberBetween(1, 5),
            'height' => fake()->numberBetween(150, 180),
            'weight' => fake()->numberBetween(50, 80),
            'imt' => fake()->randomElement(['sangat kurus', 'kurus', 'normal', 'gemuk', 'obesitas']),
            'lingkar_perut' => fake()->numberBetween(70, 100),
            'sistol' => fake()->numberBetween(120, 140),
            'diastol' => fake()->numberBetween(80, 100),
            'tekanan_darah' => fake()->randomElement(['rendah', 'normal', 'tinggi']),
            'gula_darah' => fake()->randomElement(['rendah', 'normal', 'tinggi']),
            'kadar_hb' => fake()->numberBetween(80, 100),
            'anemia' => fake()->boolean(),
            'batuk' => fake()->boolean(),
            'demam' => fake()->boolean(),
            'bb_stagnan' => fake()->boolean(),
            'kontak_tbc' => fake()->boolean(),
            'masalah_di_rumah' => fake()->boolean(),
            'masalah_di_instansi' => fake()->boolean(),
            'masalah_pola_makan' => fake()->boolean(),
            'masalah_aktivitas' => fake()->boolean(),
            'masalah_obat' => fake()->boolean(),
            'masalah_seksual' => fake()->boolean(),
            'masalah_keamanan' => fake()->boolean(),
            'masalah_depresi' => fake()->boolean(),
            
        ];
    }
}
