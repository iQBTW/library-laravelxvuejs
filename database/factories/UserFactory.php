<?php

namespace Database\Factories;

use App\Models\Member;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'name' => 'Admin',
            // 'name' => $this->faker->name,
            'email' => 'admin@gmail.com',
            // 'email' => $this->faker->safeEmail,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('123qwerty'),
            'gender' => $this->faker->randomElement(['M', 'F']),
            'phone_number' => $this->faker->numerify('085#########'),
            'address' => $this->faker->address(),
            'remember_token' => Str::random(10),
            // 'member_id' => $this->faker->randomElement(Member::where('name', '=', 'Gold')->orWhere('name', '=', 'Silver')->orWhere('name', '=', 'Bronze')->pluck('id'))
            // 'member_id' => $this->faker->randomElement(Member::where('name', '=', 'Admin')->pluck('id'))
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn(array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
