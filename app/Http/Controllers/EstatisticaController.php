<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recibo;

class EstatisticaController extends Controller
{
    public function index()
    {
        $recibos = Recibo::all();

        $title = 'Filmes';




        return view('filme.filmes', compact('filmes', 'title', 'imagens'));

        //return view('disciplina.index', ['ds' => $disciplinas]); // Passando a variável $disciplinas para a view
        //tambem poderia ser assim: return view('disciplina.index', compact('disciplinas'));
        //, neste caso a variavel $disciplinas do controlador e na view vai ter o mesmo nome
    }
}
