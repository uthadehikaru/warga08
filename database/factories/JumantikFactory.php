<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Jumantik>
 */
class JumantikFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rt' => fake()->numberBetween(1, 8),
            'name' => fake()->name(),
            'phone' => fake()->numerify('08##########'),
            'address' => fake()->address(),
            'has_jentik' => fake()->boolean(),
            'photo' => 'jumantik/sample.jpg',
        ];
    }
}
