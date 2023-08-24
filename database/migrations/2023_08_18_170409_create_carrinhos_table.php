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
        Schema::create('carrinhos', function (Blueprint $table) {
            // $table->string('id')->index();
            // $table->primary('id');

            $table->id();

            // $table->float("valor", 8, 2);

            // $table->longText('dados');

            $table->unsignedBigInteger("id_usuario")->nullable();
            $table->foreign('id_usuario')->references('id')->on('usuarios');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carrinhos');
    }
};
