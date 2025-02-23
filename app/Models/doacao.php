<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doacao extends Model
{
    use HasFactory;

    protected $table = 'doacao';

    protected $primaryKey = 'pk_doacao';

    protected $fillable = [
        'recebimento',
        'fk_doador',
        'fk_coletor'
    ];

    public function doador()
    {
        return $this->belongsTo(Doador::class, 'fk_doador');
    }

    public function coletor()
    {
        return $this->belongsTo(Coletor::class, 'fk_coletor');
    }

    public function itens()
    {
        return $this->hasMany(Item::class, 'fk_doacao');
    }
}
