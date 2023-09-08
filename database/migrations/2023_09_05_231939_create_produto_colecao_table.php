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
        Schema::create('produto_colecao', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("id_colecao")->nullable();
            $table->foreign('id_colecao')->references('id')->on('colecoes');

            $table->unsignedBigInteger("id_produto")->nullable();
            $table->foreign('id_produto')->references('id')->on('produtos');

            $table->integer("quantidade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produto_colecao');
    }
};
