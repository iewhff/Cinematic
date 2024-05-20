<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;

class SessaoController extends Controller
{
    public function escolherSessao(Request $request)
    {
        $title = 'Escolher Sessão';

        $sessoes = Sessao::where('filme_id', $request->input('filme_id'))
                ->select('id', 'filme_id', 'sala_id', 'data', 'horario_inicio')
                ->get();

                dd($sessoes);


        return view('lugar.escolherSessao', ['sessoes' => $sessoes], ['title' => $title]);
    }
}
