<?php

namespace Database\Factories;

use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;


class VendaFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        
        $produto = Produto::where('quantidade', '>', 0)->inRandomOrder()->first();

        
        if (!$produto) {
            $produto = Produto::factory()->create();
        }

        
        $comprador = User::where('id', '!=', $produto->vendedor_id)->inRandomOrder()->first();
        $vendedor = $produto->vendedor;

      
        $quantidadeComprada = $this->faker->numberBetween(1, max(1, $produto->quantidade));

        $produto->decrement('quantidade', $quantidadeComprada);

        return [
            'produto_id' => $produto->id,
            'comprador_id' => $comprador->id,
            'vendedor_id' => $vendedor->id,
            'quantidade' => $quantidadeComprada,
            'valor_unitario' => $produto->preco,
            'valor_total' => $produto->preco * $quantidadeComprada,
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'), 
            'updated_at' => now(),
        ];
    }
}
