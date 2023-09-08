<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function produto() {
        return $this->belongsTo('App\Models\Produto', "id_produto");
    }
    public function colecao() {
        return $this->belongsTo('App\Models\Colecao', "id_produto");
    }
}
