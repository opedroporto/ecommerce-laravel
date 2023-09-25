<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colecao extends Model
{
    protected $guarded = [];
    
    protected $table = "colecoes";

    use CrudTrait;

    use HasFactory;

    public function produtos() {
        return $this->belongsToMany(Produto::class, 'produto_colecao', 'id_colecao', 'id_produto');
    }
}
