<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

use App\Models;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("usuarios")->insert([
            "id" => 1,
            "role" => 1,
            "nome" => "Fran",
            "sobrenome" => "Decorações",
            "email" => "fran@gmail.com",
            "email_verified_at" => now(),
            "senha" => bcrypt("12345678"),
            "remember_token" => Str::random(10),
            "cpf" => fake()->randomNumber(3) . "." . fake()->randomNumber(3) . "." . fake()->randomNumber(3) . "-" . fake()->randomNumber(2),
            "tel" => "(" . fake()->randomNumber(2) . ")" .  " " . fake()->randomNumber(5) . "-" . fake()->randomNumber(4),
            "dtnasc" => fake()->date()
        ]);

        DB::table("enderecos")->insert([
            "num" => (string)fake()->randomNumber(2),
            "rua" => fake()->name(),
            "bairro" => fake()->name(),
            "cidade" => fake()->name(),
            "complemento" => fake()->name(),
            "cep" => (string)fake()->randomNumber(8),
            "uf" => fake()->regexify("[A-Za-z]{2}"),
            "id_usuario" => 1
        ]);
    }
}
