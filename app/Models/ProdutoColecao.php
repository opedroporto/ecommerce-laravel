<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoColecao extends Model
{
    protected $table = "produto_colecao";

    use HasFactory;

    public function produto() {
        return $this->belongsTo('App\Models\Produto', "id_produto");
    }

    public function colecao() {
        return $this->belongsTo('App\Models\Colecao', "id_colecao");
    }
}