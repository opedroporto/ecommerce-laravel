<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Models\User::factory(10)->has(
            Models\Endereco::factory()->count(1),
            "enderecos"
        )->has(
            Models\Carrinho::factory()->count(1),
            "carrinho"
        )->create();
    }
}
