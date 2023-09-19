<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    use CrudTrait;
    protected $guarded = [];

    use HasFactory;

    public function items() {
        return $this->hasMany("App\Models\Item");
    }

    public function categoria() {
        return $this->belongsTo("App\Models\Categoria", "id_categoria");
    }

    public function colecoes() {
        return $this->belongsToMany(Colecao::class, 'produto_colecao', 'id_colecao', 'id_produto');
    }
}
