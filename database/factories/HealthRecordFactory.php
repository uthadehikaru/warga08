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
            'father_name' => fake()->name(),
            'mother_name' => fake()->name(),
            'family_diseases' => fake()->randomElement([
                ['flu', 'cold', 'cough'],
                ['flu', 'cold', 'cough', 'headache'],
                ['flu', 'cold', 'cough', 'headache', 'fever'],
            ]),
            'personal_diseases' => fake()->randomElement([
                ['flu', 'cold', 'cough'],
                ['flu', 'cold', 'cough', 'headache'],
                ['flu', 'cold', 'cough', 'headache', 'fever'],
            ]),
            'user_id' => 0,
        ];
    }
}
