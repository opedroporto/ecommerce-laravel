<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pedido extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function forma_de_pagamento() {
        return $this->belongsTo("App\Models\FormaDePagamento", "id_forma_de_pagamento");
    }

    public function endereco() {
        return $this->belongsTo("App\Models\Endereco", "id_endereco");
    }

    public function usuario() {
        return $this->belongsTo("App\Models\Usuario", "id_usuario");
    }

    public function items_pedido() {
        return $this->hasMany("App\Models\Item", "id_pedido");
    }
}
