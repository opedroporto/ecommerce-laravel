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
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();

            $table->string("num", 5);
            $table->string("rua", 255);
            $table->string("bairro", 255);
            $table->string("cidade", 255);
            $table->string("complemento", 255)->nullable();
            $table->string("cep", 9);
            $table->string("uf", 2);

            $table->unsignedBigInteger("id_usuario");
            $table->foreign('id_usuario')->references('id')->on('usuarios');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enderecos');
    }
};
