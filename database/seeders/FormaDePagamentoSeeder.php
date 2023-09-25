<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FormaDePagamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // DB::table("formas_de_pagamento")->insert([
        //     "alias" => "pix",
        //     "nome" => "Pix"
        // ]);
        // DB::table("formas_de_pagamento")->insert([
        //     "alias" => "cc",
        //     "nome" => "Cartão de Crédito"
        // ]);
        // DB::table("formas_de_pagamento")->insert([
        //     "alias" => "cd",
        //     "nome" => "Cartão de Débito"
        // ]);
        // DB::table("formas_de_pagamento")->insert([
        //     "alias" => "boleto",
        //     "nome" => "Boleto"
        // ]);
        DB::table("formas_de_pagamento")->insert([
            "alias" => "c",
            "nome" => "Cartão de Crédito/Débito"
        ]);
    }
}
