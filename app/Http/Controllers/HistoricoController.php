<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Bilhete;
use App\Models\Sessao;
use App\Models\Filme;
use App\Models\Lugar;
use App\Models\Sala;

class HistoricoController extends Controller
{
    public function historico()
    {

        if (Auth::user()->tipo == 'C') {

            $bilhetes = Bilhete::where('cliente_id', Auth::user()->id)
                ->with(['sessao.sala.lugares', 'sessao.filme'])
                ->get();
                // dd($bilhetes);

            /*
ja ha relacao com estes a partir do bilhete
            $sessoes = []; // Inicialize um vetor fora do loop

            foreach ($bilhetes as $item) {
                $sessao = Sessao::where('id', $item->sessao_id)
                    ->select('filme_id', 'sala_id', 'horario_inicio')
                    ->first(); // Use first() para obter apenas um resultado

                if ($sessao) {
                    $sessoes[] = $sessao; // Adicione a sessão ao vetor
                }
            }

            $filmes = []; // Inicialize um vetor fora do loop

            foreach ($sessoes as $item) {
                $filme = Filme::where('id', $item->filme_id)
                    ->select('titulo')
                    ->first(); // Use first() para obter apenas um resultado

                if ($filme) {
                    $filmes[] = $filme; // Adicione a sessão ao vetor
                }
            }
*/
            /*
            $lugares = []; // Inicialize um vetor fora do loop

            foreach ($bilhetes as $item) {
                $lugar = Lugar::where('id', $item->lugar_id)
                    ->select('fila', 'posicao')
                    ->first(); // Use first() para obter apenas um resultado

                if ($lugar) {
                    $lugares[] = $lugar; // Adicione a sessão ao vetor
                }
            }
*/
            $lugares = Lugar::whereIn('id', $bilhetes->pluck('lugar_id')->unique())->get(['id', 'fila', 'posicao']);

            // Inicialize um índice para percorrer os lugares
            $indiceLugar = 0;

            // Iterar sobre os bilhetes
            foreach ($bilhetes as $key => $bilhete) {
                // Associar o lugar atual ao bilhete
                $bilhete->lugar = $lugares[$indiceLugar];

                // Incrementar o índice do lugar para o próximo bilhete
                $indiceLugar++;

                // Verificar se atingiu o final dos lugares disponíveis
                if ($indiceLugar >= $lugares->count()) {
                    $indiceLugar = 0; // Reiniciar o índice para reutilizar os lugares
                }
            }

            /*
            Nao e preciso salas porque ha relacao entre bilhetes e sala atraves do bilhete
            $salas = []; // Inicialize um vetor fora do loop

            foreach ($lugares as $item) {
                $sala = Sala::where('id', $item->sala_id)
                    ->select('nome')
                    ->first(); // Use first() para obter apenas um resultado

                if ($sala) {
                    $salas[] = $sala; // Adicione a sessão ao vetor
                }
            }
*/
            $title = 'Histórico';



            return view('historico.historico', compact('title', 'bilhetes', 'lugares'));
        } else {
            $h1 = 'Pedimos Desculpa';
            $title = 'Pedimos Desculpa';
            $msgErro = 'Houver um erro.';
            return view('acessoNegado.acessoNegado', compact('h1', 'title', 'msgErro'));
        }
    }
}
