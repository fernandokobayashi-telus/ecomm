<?php

namespace Database\Factories;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends Factory<User>
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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone_number' => null,
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => UserRole::User,
        ];
    }

    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    public function superAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SuperAdmin,
        ]);
    }

    public function productAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::ProductAdmin,
        ]);
    }

    public function salesAdmin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => UserRole::SalesAdmin,
        ]);
    }

    public function withPhone(): static
    {
        return $this->state(fn (array $attributes) => [
            'phone_number' => fake()->numerify('+1 (###) ###-####'),
        ]);
    }
}
