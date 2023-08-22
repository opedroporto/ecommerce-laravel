<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Endereco>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "num" => (string)fake()->randomNumber(2),
            "rua" => fake()->name(),
            "bairro" => fake()->name(),
            "cidade" => fake()->name(),
            "complemento" => fake()->name(),
            "cep" => (string)fake()->randomNumber(8),
            "uf" => fake()->regexify("[A-Za-z]{2}"),
            "id_usuario" => Models\User::pluck("id")->random()
        ];
    }
}
