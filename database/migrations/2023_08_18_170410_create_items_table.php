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
        Schema::create('items', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("id_pedido")->nullable();
            $table->foreign('id_pedido')->references('id')->on('pedidos');

            $table->unsignedBigInteger("id_carrinho")->nullable();
            $table->foreign('id_carrinho')->references('id')->on('carrinhos');

            $table->text("tipo");

            $table->text("nome");

            $table->float("valor", 8, 2);

            $table->integer("quantidade");            

            $table->unsignedBigInteger("id_produto");
            $table->foreign('id_produto')->references('id')->on('produtos');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
