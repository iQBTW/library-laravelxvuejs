<?php

namespace Database\Factories;

use App\Models\Book;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransactionDetail>
 */
class TransactionDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'transaction_id' => $this->faker->unique()->randomElement(Transaction::pluck('id')),
            'book_id' => $this->faker->randomElement(Book::pluck('id')),
            'qty' => $this->faker->numberBetween(1, 20),
        ];
    }
}
