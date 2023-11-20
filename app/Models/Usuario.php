<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Notifications\PasswordReset;

class Usuario extends Authenticatable
{
    use CrudTrait;
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $table = "usuarios";
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    // protected $fillable = [
    //     'email',
    //     'cpf',
    //     'senha',
    // ];
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'senha',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'senha' => 'hashed',
    ];

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return $this->senha;
    }

    public function enderecos() {
        return $this->hasMany("App\Models\Endereco", "id_usuario");
    }

    public function carrinho() {
        return $this->hasOne("App\Models\Carrinho", "id_usuario");
    }

    // trait CanResetPassword;

    public function sendPasswordResetNotification($token) {
        $this->notify(new PasswordReset($token));
    }
}
