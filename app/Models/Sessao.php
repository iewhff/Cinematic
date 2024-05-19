<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sessao extends Model
{
    use HasFactory;
    protected $table = 'sessoes';
    protected $dates = ['data']; // Atributo de data para a sessão

    public function bilhetes()
    {
        //para usar na estatistica
        return $this->hasMany(Bilhete::class);
    }

    public function sala()
    {
        return $this->belongsTo(Sala::class);
    }

    public function filme()
    {
        return $this->belongsTo(Filme::class);
    }
}
