<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StripeEvent extends Model
{
    protected $table = "stripe_event";

    protected $guarded = [];

    use HasFactory;
}
