<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Endereco extends Model
{
    protected $guarded = [];

    use HasFactory;

    public function usuario() {
        return $this->belongsTo("App\Models\User");
    }
}
