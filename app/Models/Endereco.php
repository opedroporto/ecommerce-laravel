<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    use CrudTrait;
    protected $guarded = [];

    use HasFactory;

    public function usuario() {
        return $this->belongsTo("App\Models\Usuario", "id_usuario");
    }
}
