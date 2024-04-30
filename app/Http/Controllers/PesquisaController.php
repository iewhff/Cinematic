<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;

class PesquisaController extends Controller
{
    public function pesquisa(Request $request)
    {
        $query = $request->input('titulo');
        $resultados = Filme::where('titulo', 'like', '%' . $query . '%')->get();

        if ($resultados->count() > 0) {
            $filme = $resultados->first();


            return view('pesquisa.resultado_pesquisa', ['resultados' => $resultados]);
        } else {
            return redirect()->back()->with('error', 'Nenhum filme encontrado com esse título.');
        }
    }
}
