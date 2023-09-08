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
        Schema::create('colecoes', function (Blueprint $table) {
            $table->id();

            $table->string("nome");
            $table->string("slug");
            $table->text("descricao")->nullable();
            $table->string("img");
            $table->float("valor", 8, 2)->nullable();
            $table->unsignedInteger("quantidade");

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('colecoes');
    }
};
