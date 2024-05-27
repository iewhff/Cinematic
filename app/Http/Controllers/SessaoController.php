<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SessaoController extends Controller
{
    public function escolherSessao(Request $request)
    {
        $title = 'Escolher Sessão';
        $filmeId = $request->input('filmeId');
        $dataAtual = Carbon::now()->toDateString();
        $horaAtualMenosCincoMinutos = Carbon::now()->subMinutes(5)->toTimeString();

        $sessoes = Sessao::join('salas', 'sessoes.sala_id', '=', 'salas.id')
                        ->where('sessoes.filme_id', $filmeId)
                        ->where(function ($query) use ($dataAtual, $horaAtualMenosCincoMinutos) {
                            $query->where('sessoes.data', '>', $dataAtual)
                                  ->orWhere(function ($query) use ($dataAtual, $horaAtualMenosCincoMinutos) {
                                      $query->where('sessoes.data', $dataAtual)
                                            ->where('sessoes.horario_inicio', '>=', $horaAtualMenosCincoMinutos);
                                  });
                        })
                        ->select('sessoes.id', 'sessoes.filme_id', 'sessoes.sala_id', 'sessoes.data', 'sessoes.horario_inicio', 'salas.nome as sala_nome')
                        ->get();




        return view('lugar.escolherSessao', ['sessoes' => $sessoes, 'title' => $title,'filmeId' => $filmeId]);
    }
    public function escolherLugar(Request $request)
    {
        $title = 'Escolher Lugares';
        $filmeId = $request->input('filmeId');
        $sessaoId = $request->input('sessao_id');
        $lugares = DB::table('lugares')
                    ->join('sessoes', 'lugares.sala_id', '=', 'sessoes.sala_id')
                    ->leftJoin('bilhetes', function ($join) use ($sessaoId) {
                        $join->on('lugares.id', '=', 'bilhetes.lugar_id')
                             ->where('bilhetes.sessao_id', '=', $sessaoId);
                    })
                    ->where('sessoes.id', $sessaoId)
                    ->select(
                        'lugares.id',
                        'lugares.fila',
                        'lugares.posicao',
                        DB::raw('IF(bilhetes.id IS NULL, 0, 1) as ocupado')
                    )
                    ->orderBy('lugares.fila')
                    ->orderBy('lugares.posicao')
                    ->get();



                // $lugares = DB::table('lugares')
        //             ->join('sessoes', 'lugares.sala_id', '=', 'sessoes.sala_id')
        //             ->where('sessoes.id', $sessaoId)
        //             ->select('lugares.fila', 'lugares.posicao')
        //             ->orderBy('lugares.fila')
        //             ->orderBy('lugares.posicao')
        //             ->get();



        return view('lugar.escolherLugares', ['title' => $title, 'lugares' => $lugares, 'sessaoId' => $sessaoId,'filmeId' => $filmeId]);
    }
}
