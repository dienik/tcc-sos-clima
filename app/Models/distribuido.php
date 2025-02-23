<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distribuido extends Model
{
    use HasFactory;

    protected $table = 'distribuido';

    public $timestamps = false;

    protected $fillable = [
        'fk_itens',
        'fk_abrigo',
        'quantidade',
        'data',
        'observacao'
    ];

    public function itens()
    {
        return $this->belongsTo(Item::class, 'fk_itens');
    }

    public function abrigo()
    {
        return $this->belongsTo(Abrigo::class, 'fk_abrigo');
    }
}
