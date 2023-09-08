<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Produto>
 */
class ColecaoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $nome = fake()->text(50);
        return [
            "nome" => $nome,
            "slug" => Str::slug($nome),
            "descricao" => fake()->paragraph(),
            "img" => fake()->imageUrl(400, 400),
            "valor" => fake()->randomNumber(3),
            "quantidade" => 1
        ];
    }
}
