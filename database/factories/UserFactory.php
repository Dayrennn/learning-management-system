<?php

namespace Database\Factories;

use App\Enum\Role;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

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
            'nomorInduk'   => fake()->unique()->numerify('############'),
            'username'     => fake()->userName(),
            'email'        => fake()->unique()->safeEmail(),
            'tanggalLahir' => fake()->date(),
            'role'         => Role::Siswa,
            'password'     => 'password',
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    // public function unverified(): static
    // {
    //     return $this->state(fn (array $attributes) => [
    //         'email_verified_at' => null,
    //     ]);
    // }
}
