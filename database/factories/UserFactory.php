<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

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
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            'dNasc' => $this->faker->date('Y-m-d', '2005-01-01'),
            'cidade' => $this->faker->city(),
            'cep' => $this->faker->postcode(),
            'logradouro' => $this->faker->streetAddress(),
            'estado' => $this->faker->state(),
            'bairro' => $this->faker->streetName(),
            'complemento' => $this->faker->secondaryAddress(),
            'cpf' => $this->faker->numerify('###.###.###-##'),
            'foto' => null,
            'remember_token' => Str::random(10),
            'saldo' => $this->faker->randomFloat(2,0,1000),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
