<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bilhete extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'recibo_id',
        'cliente_id',
        'sessao_id',
        'lugar_id',
        'preco_sem_iva',

    ];

    public function sessao()
    {
        return $this->belongsTo(Sessao::class);
    }
}
