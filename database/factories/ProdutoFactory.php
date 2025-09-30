<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ProdutoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
     public function definition(): array
    {
        return [
            'nome' => $this->faker->word(),
            'desc' => $this->faker->sentence(),
            'categoria' => $this->faker->randomElement(['Roupa','Livro','Celular','Acessorios']),
            'quantidade' => $this->faker->numberBetween(1,100),
            'preco' => $this->faker->randomFloat(2,10,1000),
            'vendedor_id' => User::inRandomOrder()->first()->id, 
            'foto' => null,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => now(),
        ];
    }
}
