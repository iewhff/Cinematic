<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;
use App\Models\Bilhete;
use App\Models\Lugar;
use App\Models\Filme;
use App\Models\Sessao;
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
        $totalBilhetesFilmeComMaisBilhetes = number_format($filmeComMaisBilhetes->total_bilhetes, 0, ',', '.');



        $generoComMaisBilhetes = Bilhete::join('sessoes', 'bilhetes.sessao_id', '=', 'sessoes.id')
            ->join('filmes', 'sessoes.filme_id', '=', 'filmes.id')
            ->select('filmes.genero_code', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
            ->groupBy('filmes.genero_code')
            ->orderByDesc('total_bilhetes')
            ->first();


        $generoCodeComMaisBilhetes = $generoComMaisBilhetes->genero_code;
        $totalBilhetesGeneroComMaisBilhetes = number_format($generoComMaisBilhetes->total_bilhetes, 0, ',', '.');


        $top10Lugares = Bilhete::join('lugares', 'bilhetes.lugar_id', '=', 'lugares.id')
            ->join('salas', 'lugares.sala_id', '=', 'salas.id')
            ->select('salas.nome as sala', 'lugares.fila', 'lugares.posicao', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
            ->groupBy('salas.nome', 'lugares.fila', 'lugares.posicao')
            ->orderByDesc('total_bilhetes')
            ->limit(10)
            ->get();


        $salasIds = Lugar::select('sala_id')->distinct()->pluck('sala_id');

        $nrTotalLugares = 0;
        foreach ($salasIds as $salaId) {
            $nrTotalLugares += Sessao::where('sala_id', $salaId)->count() * Lugar::where('sala_id', $salaId)->count();
        }
        $totalBilhetes = Bilhete::count();
        $percentagemOcupacaoGlobal = number_format(($totalBilhetes / $nrTotalLugares) * 100, 2);

        // Data do primeiro dia do último mês
        $primeiroDiaUltimoMes = Carbon::now()->subMonth()->startOfMonth()->toDateString();

        // Data do último dia do último mês
        $ultimoDiaUltimoMes = Carbon::now()->subMonth()->endOfMonth()->toDateString();


        $nrTotalLugaresUltimoMes = 0;
        foreach ($salasIds as $salaId) {
            $nrTotalLugaresUltimoMes += Sessao::where('sala_id', $salaId)->count() * Lugar::where('sala_id', $salaId)->count() * Sessao::whereBetween('data', [$primeiroDiaUltimoMes, $ultimoDiaUltimoMes])->count();
        }

        // Obtém o número de bilhetes vendidos dentro do último mês
        $totalBilhetesUltimoMes = Bilhete::whereIn('sessao_id', function ($query) use ($primeiroDiaUltimoMes, $ultimoDiaUltimoMes) {
            $query->select('id')->from('sessoes')->whereBetween('data', [$primeiroDiaUltimoMes, $ultimoDiaUltimoMes]);
        })->count();

        $percentagemOcupacaoUltimoMes = ($totalBilhetesUltimoMes / $nrTotalLugaresUltimoMes) * 100;




        $title = 'Estatistica';

        return view('estatistica.estatistica', compact('percentagemOcupacaoUltimoMes', 'percentagemOcupacaoGlobal', 'top10Lugares', 'generoCodeComMaisBilhetes', 'totalBilhetesGeneroComMaisBilhetes', 'totalBilhetesFilmeComMaisBilhetes', 'tituloFilmeComMaisBilhetes', 'mesMaisRegistrosString', 'totalRegistrosMesMaisRegistros', 'nomeClienteComMaisRecibos', 'comprasClienteComMaisRecibos', 'title'));

        //return view('disciplina.index', ['ds' => $disciplinas]); // Passando a variável $disciplinas para a view
        //tambem poderia ser assim: return view('disciplina.index', compact('disciplinas'));
        //, neste caso a variavel $disciplinas do controlador e na view vai ter o mesmo nome
    }
}
