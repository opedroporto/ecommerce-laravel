<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrinho extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function usuario() {
        $this->belongsTo(App\Models\Usuario);
    }
}
