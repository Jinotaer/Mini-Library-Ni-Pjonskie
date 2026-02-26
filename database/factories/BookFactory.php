<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $total = $this->faker->numberBetween(5, 20);

        return [
            'title' => $this->faker->sentence(3),
            'isbn' => $this->faker->unique()->numerify('978##########'),
            'authors' => null,
            'total_copies' => $total,
            'available_copies' => $this->faker->numberBetween(0, $total),
            'year_published' => $this->faker->numberBetween(1990, 2024),
        ];
    }
}
