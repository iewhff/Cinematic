<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Recibo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Filme;

class ComprarBilheteController extends Controller
{
    public function comprarBilhete(Request $request)
    {

        $query = $request->input('id');
        $resultados = Filme::where('id', 'like', '%' . $query . '%')->get();

        $title = 'Comprar Bilhete';
        return view('bilhete.comprarBilhete', compact('title'));
    }

    public function criarBilhete(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data' => 'required|date|equal:today',
            'preco_total_sem_iva' => 'required',
            'iva' => 'required|numeric|between:0,100',
            'nif' => 'required|numeric|digits:9',
            'nome_cliente' => 'required|string|max:55',
            'tipo_pagamento' => 'required|string|max:55',
            'ref_pagamento' => 'required|string|max:55',
            //Tentar adicionar depois o campo de upload de ficheiros
            //'recibo_pdf_url' => 'required',
            'created_at' => 'required|date|equal:today',
        ], [ // Custom Error Messages
            'nif.required' => 'NIF é obrigatório.',
            'nome_cliente.required' => 'Nome é obrigatório.',
            'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
            'ref_pagamento.required' => 'Referencia de pagamento é obrigatório.',
        ]);
        Recibo::create($request->toArray());
        return "sucesso";
    }

    public function criarRecibo(Request $request)
    {
        $validated = $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'data' => 'required|date|equal:today',
            'preco_total_sem_iva' => 'required',
            'iva' => 'required|numeric|between:0,100',
            'nif' => 'required|numeric|digits:9',
            'nome_cliente' => 'required|string|max:55',
            'tipo_pagamento' => 'required|string|max:55',
            'ref_pagamento' => 'required|string|max:55',
            //Tentar adicionar depois o campo de upload de ficheiros
            //'recibo_pdf_url' => 'required',
            'created_at' => 'required|date|equal:today',
        ], [ // Custom Error Messages
            'nif.required' => 'NIF é obrigatório.',
            'nome_cliente.required' => 'Nome é obrigatório.',
            'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
            'ref_pagamento.required' => 'Referencia de pagamento é obrigatório.',
        ]);
        Recibo::create($request->toArray());
        return "sucesso";
    }
}
