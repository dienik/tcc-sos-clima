<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abrigo extends Model
{
    use HasFactory;

    protected $table = 'abrigo';

    protected $primaryKey = 'pk_abrigo';

    protected $fillable = [
        'nome',
        'rua',
        'numero',
        'cidade',
        'estado',
        'cep',
        'telefone',
        'cnpj',
        'email'
    ];
    public function prioridades()
    {
        return $this->belongsToMany(prioridade::class, 'tem', 'fk_abrigo', 'fk_prioridades')
                    ->withPivot('precisando'); // Para acessar a coluna precisando
    }
    public function abrigados()
    {
        return $this->hasMany(Abrigado::class, 'fk_abrigo');
    }

    public function responsaveis()
    {
        return $this->hasMany(Responsavel::class, 'fk_abrigo');
    }

    public function distribuicoes()
    {
        return $this->hasMany(Distribuido::class, 'fk_abrigo');
    }
}
