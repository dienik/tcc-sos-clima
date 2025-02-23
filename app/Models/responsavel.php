<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Responsavel extends Model
{
    use HasFactory;

    protected $table = 'responsaveis';

    protected $primaryKey = 'pk_responsavel';

    protected $fillable = [
        'atribuicao',
        'fk_abrigo',
        'nome'
    ];

    public function abrigo()
    {
        return $this->belongsTo(Abrigo::class, 'fk_abrigo');
    }
}
