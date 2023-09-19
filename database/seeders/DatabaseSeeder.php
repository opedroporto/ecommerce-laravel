<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            // CarrinhoSeeder::class,
            // EnderecoSeeder::class,
            AdminUsuarioSeeder::class,
            UsuarioSeeder::class,
            CategoriaSeeder::class,
            ProdutoSeeder::class,
            ColecaoSeeder::class,
            ProdutoColecaoSeeder::class,
            FormaDePagamentoSeeder::class
        ]);
    }
}
