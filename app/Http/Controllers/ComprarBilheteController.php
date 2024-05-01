<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Recibo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Configuracao;
use Carbon\Carbon;

class ComprarBilheteController extends Controller
{
    public function comprarBilhete(Request $request)
    {

        $query = $request->input('id');
        $resultados = Filme::where('id', $query)->get();

        $title = 'Comprar Bilhete';
        return view('bilhete.comprarBilhete', compact('title', 'resultados'));
    }

    public function criarBilhete(Request $request)
    {
        $validated = $request->validate([
            'nif' => 'required|numeric|digits:9',
            'nome_cliente' => 'required|string|max:55',
            'tipo_pagamento' => 'required|string|max:55',
            'ref_pagamento' => 'required|string|max:55',
            //Tentar adicionar depois o campo de upload de ficheiros
            //'recibo_pdf_url' => 'required',
        ], [ // Custom Error Messages
            'id' => 'NIF é obrigatório.',
            'nome_cliente.required' => 'Nome é obrigatório.',
            'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
            'ref_pagamento.required' => 'Referencia de pagamento é obrigatório.',
        ]);

        // Definir valores automaticamente
        $id = Recibo::max('id') + 1;
        $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');
        $clienteId = auth()->id(); // Laravel helper para id do utilizador autenticado

        // Adicionar ao array validado
        $dadosCompletos = array_merge($validated, [
            'id' => $id,
            'recibo_id' => $request->input('recibo_id'),
            'sessao_id' => $request->input('sessao_id'),
            'data' => $dataHoraAtual,
            'created_at' => $dataHoraAtual,
            'cliente_id' => $clienteId,
        ]);

        Recibo::create($dadosCompletos);
        return "sucesso";
    }

    public function criarRecibo(Request $request)
    {
        $configuracao = Configuracao::all();

        $validated = $request->validate([
            'nif' => 'required|numeric|digits:9',
            'nome_cliente' => 'required|string|max:55',
            'tipo_pagamento' => 'required|string|max:55',
            'ref_pagamento' => 'required|string|max:55',
            //Tentar adicionar depois o campo de upload de ficheiros
            //'recibo_pdf_url' => 'required',
        ], [ // Custom Error Messages
            'nif.required' => 'NIF é obrigatório.',
            'nome_cliente.required' => 'Nome é obrigatório.',
            'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
            'ref_pagamento.required' => 'Referencia de pagamento é obrigatório.',
        ]);

        // Definir valores automaticamente
        $id = Recibo::max('id') + 1;
        $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');
        $clienteId = auth()->id(); // Laravel helper para id do utilizador autenticado
        $preco_total_sem_iva = $configuracao->preco_total_sem_iva;
        $iva = $configuracao->percentagem_iva;

        // Adicionar ao array validado
        $dadosCompletos = array_merge($validated, [
            'id' => $id,
            'data' => $dataHoraAtual,
            'created_at' => $dataHoraAtual,
            'cliente_id' => $clienteId,
            'preco_total_sem_iva' => $preco_total_sem_iva,
            'percentagem_iva' => $iva,
        ]);

        Recibo::create($dadosCompletos);
        return "sucesso";
    }
}
