<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Usuario extends Authenticatable
{
    use HasFactory;

    protected $table = 'usuarios';
    protected $primaryKey = 'id';

    protected $fillable = [
        'nome',
        'sobrenome',
        'telefone',
        'email',
        'senha',
        'administrador',
    ];

    protected $hidden = [
        'senha',
    ];

    protected $casts = [
        'senha' => 'hashed', // Laravel 10+ - Garante que a senha seja tratada corretamente
    ];

    // Define corretamente a senha no banco de dados
    public function setPasswordAttribute($value)
    {
        $this->attributes['senha'] = bcrypt($value);
    }

    // Informar ao Laravel que o campo correto da senha é 'senha'
    public function getAuthPassword()
    {
        return $this->senha;
    }
}
