<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tem extends Model
{
    use HasFactory;

    protected $table = 'tem';

    public $timestamps = false;

    protected $fillable = [
        'fk_prioridades',
        'fk_abrigo',
        'precisando'
    ];

    public function prioridade()
    {
        return $this->belongsTo(Prioridade::class, 'fk_prioridades');
    }

    public function abrigo()
    {
        return $this->belongsTo(Abrigo::class, 'fk_abrigo');
    }
}
