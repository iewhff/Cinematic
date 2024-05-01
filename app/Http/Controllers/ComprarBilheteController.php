<?php

namespace App\Http\Controllers;

use App\Models\Bilhete;
use App\Models\Cliente;
use App\Models\Recibo;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Configuracao;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class ComprarBilheteController extends Controller
{
    public function comprarBilhete(Request $request)
    {
        $resultados = DB::select('SELECT * FROM configuracao');
        $configuracao = $resultados[0];
        $preco_bilhete = $configuracao->preco_bilhete_sem_iva * 0.1 * $configuracao->percentagem_iva;
        $preco_bilhete = number_format($preco_bilhete, 2, '.', '');

        $query = $request->input('id');
        $resultados = Filme::where('id', $query)->get();

        $title = 'Comprar Bilhete';
        return view('bilhete.comprarBilhete', compact('title', 'resultados', 'preco_bilhete'));
    }

    public function criarReciboBilhete(Request $request)
    {
        //Criar Recibo---------------------------------------
        $resultados = DB::select('SELECT * FROM configuracao');

        $configuracao = $resultados[0];

        $validatedRecibo = $request->validate([
            'nif' => 'numeric|digits:9',
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
        $id_recibo = Recibo::max('id') + 1;
        $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');
        $preco_total_sem_iva = $configuracao->preco_bilhete_sem_iva;
        $iva = 0.1 * $configuracao->percentagem_iva;
        $preco_total_com_iva = $configuracao->preco_bilhete_sem_iva * 0.1 * $configuracao->percentagem_iva;
        $clienteId = Cliente::max('id');

        // Adicionar ao array validado
        $dadosCompletosRecibo = array_merge($validatedRecibo, [
            'id' => $id_recibo,
            'cliente_id' => $clienteId,
            'data' => $dataHoraAtual,
            'preco_total_sem_iva' => $preco_total_sem_iva,
            'iva' => $iva,
            'preco_total_com_iva' => $preco_total_com_iva,
            'created_at' => $dataHoraAtual,
        ]);

        // Criar bilhete ---------------------------------------
        // Definir valores automaticamente
        $id_bilhete = Bilhete::max('id') + 1;
        $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');

        // Adicionar ao array validado
        $dadosCompletosBilhete = [
            'id' => $id_bilhete,
            'recibo_id' => $id_recibo,
            'cliente_id' => $clienteId,
            'sessao_id' => 1, //falta fazer a relação com a sessão      TODO
            'lugar_id' => 34, //falta fazer a relação com o lugar        TODO
            'preco_sem_iva' => $preco_total_sem_iva,
            'estado' => 'não usado',
            'created_at' => $dataHoraAtual
        ];

        Recibo::create($dadosCompletosRecibo);
        Bilhete::create($dadosCompletosBilhete);
        return "sucesso";
    }
}
