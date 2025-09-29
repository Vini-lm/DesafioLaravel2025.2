<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administrador>
 */
class AdministradorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
             'name' => $this->faker->name(),
             'email' => $this->faker->unique()->safeEmail(),
             'password' => bcrypt('password'),
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
        ];
    }
}
