<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coletor extends Model
{
    use HasFactory;

    protected $table = 'coletor';

    protected $primaryKey = 'pk_coletor';

    protected $fillable = [
        'nome',
        'sobrenome',
        'email'
    ];

    public function doacoes()
    {
        return $this->hasMany(Doacao::class, 'fk_coletor');
    }
}
