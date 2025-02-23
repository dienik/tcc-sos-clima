<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doador extends Model
{
    use HasFactory;

    protected $table = 'doador';

    protected $primaryKey = 'pk_doador';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email',
        'telefone',
        'cnpj',
        'cpf',
        'endereco'
    ];

    public function doacoes()
    {
        return $this->hasMany(Doacao::class, 'fk_doador');
    }
}
