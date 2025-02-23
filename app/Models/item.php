<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'itens';

    protected $primaryKey = 'pk_itens';

    protected $fillable = [
        'fk_doacao',
        'descricao',
        'quantidade',
        'validade'
    ];

    public function doacao()
    {
        return $this->belongsTo(Doacao::class, 'fk_doacao');
    }
}
