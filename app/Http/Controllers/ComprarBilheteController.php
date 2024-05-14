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
use App\Models\Sessao;
use Faker\Core\Number;
use Illuminate\Support\Facades\Auth;

use function Laravel\Prompts\form;
use Illuminate\Support\Facades\Http;

class ComprarBilheteController extends Controller
{
        public function comprarBilhete(Request $request)
        {
            if (Auth::user()->tipo == 'C') {

                $strFilmesID = $request->input('filmesID');
                $precoTotal = $request->input('precoTotal');

                // Explode the string into an array using ',' as the delimiter
                $arrFilmesID = explode(',', $strFilmesID);

                // Filter the array to remove any empty elements and ensure numeric values
                $arrFilmesID = array_filter($arrFilmesID, function($value) {
                    return is_numeric($value);
                });

                // Optionally, reindex the array to ensure the keys are in order
                $arrFilmesID = array_values($arrFilmesID);

                $preco = DB::select('SELECT * FROM configuracao');
                $configuracao = $preco[0];
                $preco_bilhete_unitario = $configuracao->preco_bilhete_sem_iva * (1 + $configuracao->percentagem_iva / 100);

                $preco_bilhete=0;
                $resultados = [];

                foreach ($arrFilmesID as $filmeID) {
                    $filme = Filme::find($filmeID);

                    if ($filme) {
                        $dataAtual = Carbon::now()->toDateString(); // Obtém a data atual

                        $lugaresDisponiveisTotal = DB::table('sessoes')
                        ->join('lugares', 'sessoes.sala_id', '=', 'lugares.sala_id')
                        ->leftJoin('bilhetes', function ($join) {
                            $join->on('sessoes.id', '=', 'bilhetes.sessao_id')
                            ->on('lugares.id', '=', 'bilhetes.lugar_id');
                        })
                        ->select('sessoes.id as sessao_id', 'sessoes.data', 'sessoes.horario_inicio', 'sessoes.sala_id', 'lugares.id as lugar_id', 'lugares.fila', 'lugares.posicao')
                        ->where('sessoes.filme_id', $filmeID)
                        ->whereDate('sessoes.data', '>=', $dataAtual)
                        ->whereNull('bilhetes.lugar_id')
                        ->get();

                        $resultados[] = [
                            'filme' => $filme,
                            'lugaresDisponiveisTotal' => $lugaresDisponiveisTotal
                        ];
                    }
                    $preco_bilhete +=$preco_bilhete_unitario;
                }

                $preco_bilhete = number_format($preco_bilhete, 2, '.', '');

                // Add nif ao cliente se ele nao tiver definido nif na conta mas tiver posto nif na compra
                $cliente = Cliente::where('id', Auth::user()->id)
                    ->whereNull('nif')
                    ->first();



                $title = 'Comprar Bilhete';
                return view('bilhete.comprarBilhete', compact('resultados', 'title', 'preco_bilhete'));
            } else {
                // Acesso negado para clientes não autorizados
                $h1 = 'Pedimos Desculpa';
                $title = 'Acesso Negado';
                $msgErro = 'Apenas Clientes podem comprar bilhetes.';
                return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
            }
        }

        public function criarReciboBilhete(Request $request)
        {
            if (Auth::user()->tipo != 'C') {
                // Acesso negado para clientes não autorizados
                $h1 = 'Pedimos Desculpa';
                $title = 'Acesso Negado';
                $msgErro = 'Apenas Clientes podem comprar bilhetes.';
                return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
            }

            $accepted = false;

            // Validação dos diferentes tipos de pagamento
            if ($request->input('mbway_numero')) {
                $request->validate([
                    'mbway_numero' => 'required|numeric|digits:9',
                ], [ // Custom Error Messages
                    'mbway_numero.required' => 'Numero de telefone é obrigatório.',
                ]);
                $accepted = true;
            } elseif ($request->input('visa_numero') && $request->input('visa_cvc')) {
                $request->validate([
                    'visa_numero' => 'required|numeric|digits:16',
                    'visa_cvc' => 'required|numeric|digits:3',
                ], [ // Custom Error Messages
                    'visa_numero.required' => 'Numero do visa é obrigatório.',
                    'visa_cvc.required' => 'CVC do visa é obrigatório.',
                ]);
                $accepted = true;
            } elseif ($request->input('paypal_email')) {
                $request->validate([
                    'paypal_email' => 'required|email|max:250',
                ], [ // Custom Error Messages
                    'paypal_email.required' => 'Email é obrigatório.',
                ]);
                $accepted = true;
            }

            if (!$accepted) {
                $h1 = 'Pedimos Desculpa';
                $title = 'Dados de Pagamento Inválidos';
                $msgErro = 'Por favor, forneça dados de pagamento válidos.';
                return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
            }

            // Validação do recibo
            $validatedRecibo = $request->validate([
                'nif' => 'nullable|numeric|digits:9',
                'nome_cliente' => 'required|string|max:55',
                'tipo_pagamento' => 'required|string|max:55',
                'ref_pagamento' => 'required|string|max:55',
            ], [ // Custom Error Messages
                'nome_cliente.required' => 'Nome é obrigatório.',
                'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
                'ref_pagamento.required' => 'Referência de pagamento é obrigatório.',
            ]);

            $nrBilhetes = $request->input('nrBilhetes');
            $sessao_id = [];
            $lugar_id = [];

            for ($i = 0; $i < $nrBilhetes; $i++) {
                // Extrair sessao_id e lugar_id, porque está no formato 11514-153 (sessao_id-lugar_id) no POST['lugar'.$i]
                $sessao = substr($request->input('lugar' . $i), 0, strpos($request->input('lugar' . $i), '-'));
                $lugar = substr($request->input('lugar' . $i), strpos($request->input('lugar' . $i), '-') + 1);

                // Verificar se o lugar_id já está no array
                if (!in_array($lugar, $lugar_id)) {
                    $sessao_id[] = $sessao;
                    $lugar_id[] = $lugar;
                }
            }

            $resultados = DB::select('SELECT * FROM configuracao');
            $configuracao = $resultados[0];
            $preco_bilheteComIva = $configuracao->preco_bilhete_sem_iva * (1 + $configuracao->percentagem_iva / 100);
            $precoTotal = number_format(count($sessao_id) * $preco_bilheteComIva, 2, '.', '');
            $precoTotalSemIva = number_format(count($sessao_id) * $configuracao->preco_bilhete_sem_iva, 2, '.', '');

            // Verificar se já existe um bilhete para essa sessão e lugar
            $existeRegistro = false;
            for($i=0; $i<count($sessao_id); $i++){
                $existeRegistro = Bilhete::where('sessao_id', $sessao_id[$i])
                    ->where('lugar_id', $lugar_id[$i])
                    ->exists();

                if ($existeRegistro) {
                    $existeRegistro = true;
                    break;
                }
            }

            if (!$existeRegistro) {
                // Criar recibo
                $clienteId = Auth::user()->id;
                DB::beginTransaction();

                try {
                    $recibo = Recibo::create([
                        'nif' => $request->input('nif'),
                        'nome_cliente' => $request->input('nome_cliente'),
                        'tipo_pagamento' => $request->input('tipo_pagamento'),
                        'ref_pagamento' => $request->input('ref_pagamento'),
                        'cliente_id' => $clienteId,
                        'data' => Carbon::now(),
                        'preco_total_sem_iva' => $precoTotalSemIva,
                        'iva' => $configuracao->percentagem_iva,
                        'preco_total_com_iva' => $precoTotal,
                    ]);


                    for($i=0; $i<count($sessao_id); $i++){
                        // Criar bilhete
                        Bilhete::create([
                            'recibo_id' => $recibo->id,
                            'cliente_id' => $clienteId,
                            'sessao_id' => $sessao_id[$i],
                            'lugar_id' => $lugar_id[$i],
                            'preco_sem_iva' => $configuracao->preco_bilhete_sem_iva,
                            'estado' => 'não usado',
                            'created_at' => Carbon::now(),
                        ]);
                    }



                    DB::commit();
                    // remover tudo do carrinho
                    session()->forget('carrinho');

                    $h1 = 'Bilhete Comprado com Sucesso';
                    $title = 'Bilhete Comprado com Sucesso';
                    $msgErro = 'Obrigado por ter comprado conosco, volte sempre.';
                    return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));

                } catch (\Exception $e) {
                    DB::rollBack();
                    $h1 = 'Pedimos Desculpa';
                    $title = 'Erro na Compra';
                    $msgErro = 'Ocorreu um erro durante a compra. Por favor, tente novamente.';
                    return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
                }
            } else {
                $h1 = 'Pedimos Desculpa';
                $title = 'Lugar Já Comprado';
                $msgErro = 'O lugar já foi comprado. Quando voltar atrás pressione F5 para atualizar a página.';
                return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
            }
        }

    // public function criarRecibosBilhetes(Request $request)
    // {
    //     if (Auth::user()->tipo == 'C') {
    //         if (is_array($request->lugaresDisponiveisTotal)) {
    //             foreach ($request->lugaresDisponiveisTotal as $lugaresDisponiveisTotal) {
    //                 // Verifique se $lugaresDisponiveisTotal é uma string válida
    //                 var_dump($lugaresDisponiveisTotal);

    //                 //Criar Recibo---------------------------------------
    //                 $resultados = DB::select('SELECT * FROM configuracao');
    //                 $configuracao = $resultados[0];

    //                 $validatedRecibo = $request->validate([
    //                     'nif' => 'numeric|digits:9',
    //                     'nome_cliente' => 'required|string|max:55',
    //                     'tipo_pagamento' => 'required|string|max:55',
    //                     'ref_pagamento' => 'required|string|max:55',
    //                     //Tentar adicionar depois o campo de upload de ficheiros
    //                     //'recibo_pdf_url' => 'required',
    //                 ], [ // Custom Error Messages
    //                     'nome_cliente.required' => 'Nome é obrigatório.',
    //                     'tipo_pagamento.required' => 'Tipo de pagamento é obrigatório.',
    //                     'ref_pagamento.required' => 'Referencia de pagamento é obrigatório.',
    //                 ]);

    //                 // Definir valores automaticamente
    //                 $id_recibo = Recibo::max('id') + 1;
    //                 $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');
    //                 $preco_total_sem_iva = $configuracao->preco_bilhete_sem_iva;
    //                 $iva = 0.1 * $configuracao->percentagem_iva;
    //                 $preco_total_com_iva = $configuracao->preco_bilhete_sem_iva * 0.1 * $configuracao->percentagem_iva;
    //                 $clienteId = Cliente::max('id');

    //                 // Adicionar ao array validado
    //                 $dadosCompletosRecibo = array_merge($validatedRecibo, [
    //                     'id' => $id_recibo,
    //                     'cliente_id' => $clienteId,
    //                     'data' => $dataHoraAtual,
    //                     'preco_total_sem_iva' => $preco_total_sem_iva,
    //                     'iva' => $iva,
    //                     'preco_total_com_iva' => $preco_total_com_iva,
    //                     'created_at' => $dataHoraAtual,
    //                 ]);

    //                 // Criar recibo
    //                 Recibo::create($dadosCompletosRecibo);

    //                 // Criar bilhete ---------------------------------------
    //                 // Obter IDs da sessão e do lugar separados por hífen
    //                 $ids = explode('-', $lugaresDisponiveisTotal);
    //                 if (count($ids) == 2) { // Certifique-se de que temos dois IDs separados
    //                     $sessao_id = $ids[0];
    //                     $lugar_id = $ids[1];

    //                     // Definir valores automaticamente
    //                     $id_bilhete = Bilhete::max('id') + 1;
    //                     $dataHoraAtual = Carbon::now()->format('Y-m-d H:i:s');

    //                     // Adicionar ao array validado
    //                     $dadosCompletosBilhete = [
    //                         'id' => $id_bilhete,
    //                         'recibo_id' => $id_recibo,
    //                         'cliente_id' => $clienteId,
    //                         'sessao_id' => $sessao_id,
    //                         'lugar_id' => $lugar_id,
    //                         'preco_sem_iva' => $preco_total_sem_iva,
    //                         'estado' => 'não usado',
    //                         'created_at' => $dataHoraAtual
    //                     ];

    //                     // Criar bilhete
    //                     Bilhete::create($dadosCompletosBilhete);
    //                 } else {
    //                     $h1 = 'Pedimos Desculpa';
    //                     $title = 'Pedimos Desculpa';
    //                     $msgErro = 'Houver um erro.';
    //                     return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
    //                 }
    //             }
    //         }

    //         return "sucesso";
    //     } else {
    //         $h1 = 'Pedimos Desculpa';
    //         $title = 'Acesso Negado';
    //         $msgErro = 'Apenas Cliente podem comprar bilhetes.';
    //         return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
    //     }
    // }
}
