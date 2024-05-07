<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sala extends Model
{
    use HasFactory;

    // Defina a relação com a tabela lugares
    public function lugares()
    {
        return $this->hasMany(Lugar::class);
    }
}
