<?php

namespace Database\Seeders;

use App\Models\Administrador;
use App\Models\Compra;
use App\Models\Produto;
use App\Models\Administrador;
use App\Models\Compra;
use App\Models\Produto;
use App\Models\User;
use App\Models\Venda;   
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

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
            'password' => Hash::make('123'),
        ]);
        User::factory()->create([
            'name' => 'Vinicius',
            'email' => 'vinicius@gmail.com',
            'password' => Hash::make('123'),
            'isAdmin' => true,
        ]);

       
        User::factory(10)->create()->each(function ($user) {
            Produto::factory(rand(1, 5))->create([
                'vendedor_id' => $user->id,
            ]);
        });

        
        Venda::factory(50)->create();

    }
}
