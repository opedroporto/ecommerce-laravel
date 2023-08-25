<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formas_de_pagamento', function (Blueprint $table) {
            $table->id();

            $table->text("alias");
            $table->text("nome");

            // $table->boolean("boleto")->default(false);
            // $table->boolean("cartao_credito")->default(false);
            // $table->boolean("cartao_debito")->default(false);
            // $table->boolean("pix")->default(false);

            // $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formas_de_pagamento');
    }
};
