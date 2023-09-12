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
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();

            $table->string("nome", 50);
            $table->text("descricao");
            $table->string("img", 150);
            $table->float("valor", 8, 2);
            $table->string("slug", 50);
            $table->unsignedInteger("quantidade");

            $table->unsignedBigInteger("id_categoria");
            $table->foreign('id_categoria')->references('id')->on('categorias')->onUpdate("restrict")->onDelete("restrict");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
