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
        return [
            'isbn' => $this->faker->numberBetween(1, 500),
            'title' => $this->faker->sentence(5),
            'year' => $this->faker->year(),
            'publisher_id' => $this->faker->numberBetween(1, 5),
            'author_id' => $this->faker->numberBetween(1, 20),
            'catalog_id' => $this->faker->numberBetween(1, 4),
            'qty' => $this->faker->numberBetween(1, 20),
            'price' => $this->faker->numberBetween(1000, 50000),
        ];
    }
}
