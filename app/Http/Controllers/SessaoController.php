<?php

namespace App\Http\Controllers;

use App\Models\Sessao;
use Illuminate\Http\Request;

class SessaoController extends Controller
{
    public function index(Request $request)
    {

        $sessoes = Sessao::where('filme_id', $request->input('filme_id'))
                ->select('id', 'filme_id', 'sala_id', 'data', 'horario_inicio')
                ->get();


        return view('sessao.index');
    }
}
