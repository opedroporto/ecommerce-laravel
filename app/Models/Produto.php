<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function items() {
        return $this->hasMany("App\Models\Item");
    }

    public function categoria() {
        return $this->belongsTo("App\Models\Categoria", "id_categoria");
    }
}
