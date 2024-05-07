<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarrinhoComprasController extends Controller
{
    public function carrinhoCompras()
    {
        $title = 'Carrinho Compras';
        return view('carrinhoCompras.carrinhoCompras', compact('title'));
    }
}
