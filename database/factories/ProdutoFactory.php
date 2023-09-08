<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models;

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
        $nome = fake()->text(50);
        return [
            "nome" => $nome,
            "descricao" => fake()->paragraph(),
            "img" => fake()->imageUrl(400, 400),
            "valor" => fake()->randomNumber(2) + 1,
            "slug" => Str::slug($nome),
            "quantidade" => fake()->randomNumber(1),
            "id_categoria" => Models\Categoria::pluck("id")->random()
        ];
    }
}
