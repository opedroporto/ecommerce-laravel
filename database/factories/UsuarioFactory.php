<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

use App\Models;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UsuarioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // $cpf = (string)fake()->randomNumber(11)->unique();

        return [
            "role" => 0,
            "nome" => fake()->name(),
            "sobrenome" => fake()->name(),
            "email" => fake()->unique()->safeEmail(),
            "email_verified_at" => now(),
            // "senha" => "$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi", // password
            "senha" => bcrypt("12345678"),
            "remember_token" => Str::random(10),
            // "cpf" => fake()->randomNumber(3) . "." . fake()->randomNumber(3) . "." . fake()->randomNumber(3) . "-" . fake()->randomNumber(2),
            "cpf" => fake()->numerify("###-###-###.##"),
            // "tel" => "(" . fake()->randomNumber(2) . ")" .  " " . fake()->randomNumber(5) . "-" . fake()->randomNumber(4),
            "tel" => fake()->numerify("(##) #####-####"),
            "dtnasc" => fake()->date()
        ];
    }

    /**
     * Indicate that the model"s email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            "email_verified_at" => null,
        ]);
    }
}
