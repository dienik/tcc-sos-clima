<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abrigado extends Model
{
    use HasFactory;

    protected $table = 'abrigado';

    protected $primaryKey = 'pk_abrigado';

    protected $fillable = [
        'fk_abrigo',
        'nome',
        'sobrenome',
        'cidade_origem',
        'telefone',
        'data_saida',
        'informacoes'
    ];

    public function abrigo()
    {
        return $this->belongsTo(Abrigo::class, 'fk_abrigo');
    }
}
