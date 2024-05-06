<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;
use App\Models\Bilhete;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EstatisticaController extends Controller
{
    public function index()
    {

        $mesesComRegistros = Bilhete::whereNotNull('created_at')
            ->select(DB::raw('MONTH(created_at) as mes'), DB::raw('COUNT(*) as total'))
            ->groupBy('mes')
            ->orderByDesc('total')
            ->first();

        // O mês com o maior número de registros
        $mesMaisRegistros = $mesesComRegistros->mes;
        $mesMaisRegistrosString =  ucfirst(Carbon::create()->locale('pt_BR')->month($mesMaisRegistros)->monthName);
        $totalRegistrosMesMaisRegistros = $mesesComRegistros->total;
        // O número total de registros para o mês com o maior número

        $clienteComMaisRecibos = Recibo::whereNotNull('cliente_id')
            ->select(DB::raw('COUNT(*) as total'), 'nome_cliente')
            ->groupBy('nome_cliente') // Agrupar pelo nome do cliente
            ->orderByDesc('total')
            ->first();

        $nomeClienteComMaisRecibos = $clienteComMaisRecibos->nome_cliente;
        $comprasClienteComMaisRecibos = $clienteComMaisRecibos->total;

        $filmeComMaisBilhetes = Bilhete::join('sessoes', 'bilhetes.sessao_id', '=', 'sessoes.id')
            ->join('filmes', 'sessoes.filme_id', '=', 'filmes.id')
            ->select('filmes.titulo', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
            ->groupBy('filmes.titulo')
            ->orderByDesc('total_bilhetes')
            ->first();

        $tituloFilmeComMaisBilhetes = $filmeComMaisBilhetes->titulo;
        $totalBilhetesFilmeComMaisBilhetes = $filmeComMaisBilhetes->total_bilhetes;

        $generoComMaisBilhetes = Bilhete::join('sessoes', 'bilhetes.sessao_id', '=', 'sessoes.id')
            ->join('filmes', 'sessoes.filme_id', '=', 'filmes.id')
            ->select('filmes.genero_code', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
            ->groupBy('filmes.genero_code')
            ->orderByDesc('total_bilhetes')
            ->first();

        $generoCodeComMaisBilhetes = $generoComMaisBilhetes->genero_code;
        $totalBilhetesGeneroComMaisBilhetes = $generoComMaisBilhetes->total_bilhetes;

        $top10Lugares = Bilhete::join('lugares', 'bilhetes.lugar_id', '=', 'lugares.id')
            ->join('salas', 'lugares.sala_id', '=', 'salas.id')
            ->select('salas.nome as sala', 'lugares.fila', 'lugares.posicao', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
            ->groupBy('salas.nome', 'lugares.fila', 'lugares.posicao')
            ->orderByDesc('total_bilhetes')
            ->limit(10)
            ->get();


        $title = 'Filmes';

        return view('estatistica.estatistica', compact('top10Lugares', 'generoCodeComMaisBilhetes', 'totalBilhetesGeneroComMaisBilhetes', 'totalBilhetesFilmeComMaisBilhetes', 'tituloFilmeComMaisBilhetes', 'mesMaisRegistrosString', 'totalRegistrosMesMaisRegistros', 'nomeClienteComMaisRecibos', 'comprasClienteComMaisRecibos', 'title'));

        //return view('disciplina.index', ['ds' => $disciplinas]); // Passando a variável $disciplinas para a view
        //tambem poderia ser assim: return view('disciplina.index', compact('disciplinas'));
        //, neste caso a variavel $disciplinas do controlador e na view vai ter o mesmo nome
    }
}
