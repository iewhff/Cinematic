<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recibo extends Model
{
    use HasFactory;

    protected $fillable = [
        'data',
        'created_at',
        'cliente_id',
        'preco_total_sem_iva',
        'percentagem_iva',
        'nif', // Adicione aqui o atributo que está causando o erro
        'iva',
        'preco_total_com_iva',
        'nome_cliente',
        'ref_pagamento',
    ];
}
