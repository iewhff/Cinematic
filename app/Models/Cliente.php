<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $table = 'clientes';
    protected $dates = ['deleted_at', 'updated_at', 'created_at'];
    protected $fillable = [
        'nif',
        'tipo_pagamento',
        'ref_pagamento',
        'custom'
    ];

    public static $tipoPagamentos = ['VISA', 'PAYPAL', 'MBWAY'];

    public function user()
    {
        return $this->belongsTo(User::class, 'id');
    }

}
