<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prioridade extends Model
{
    use HasFactory;

    protected $table = 'prioridades';

    protected $primaryKey = 'pk_prioridade';

    protected $fillable = [
        'descricao'
    ];
    public function abrigos()
    {
        return $this->belongsToMany(abrigo::class, 'tem', 'fk_prioridades', 'fk_abrigo')
                    ->withPivot('precisando');
    }
    public function tem()
    {
        return $this->hasMany(Tem::class, 'fk_prioridades');
    }
}
