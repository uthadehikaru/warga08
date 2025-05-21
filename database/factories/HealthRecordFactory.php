<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthRecord>
 */
class HealthRecordFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'father_name' => fake()->sentence(2),
            'mother_name' => fake()->sentence(2),
            'family_diseases' => fake()->randomElement([
                ['dm', 'hipertensi', 'stroke'],
                ['dm', 'hipertensi', 'stroke', 'jantung'],
                ['dm', 'hipertensi', 'stroke', 'jantung', 'asma'],
            ]),
            'personal_diseases' => fake()->randomElement([
                ['dm', 'hipertensi', 'stroke'],
                ['dm', 'hipertensi', 'stroke', 'jantung'],
                ['dm', 'hipertensi', 'stroke', 'jantung', 'asma'],
            ]),
            'user_id' => 0,
        ];
    }
}
