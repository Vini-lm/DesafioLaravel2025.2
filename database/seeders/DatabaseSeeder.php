<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Compra;
use App\Models\Produto;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => '123',
        ]);


        User::factory(20)->create();
        Administrador::factory(10)->create();
        Produto::factory(30)->create();
        Compra::factory(20)->create([
            'cliente_id' => User::inRandomOrder()->first()->id,
            'produto_id' => Produto::inRandomOrder()->first()->id,
        ]);
    }
}
