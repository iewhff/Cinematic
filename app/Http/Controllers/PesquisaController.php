<?php
namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class PesquisaController extends Controller
{
    public function pesquisa(Request $request)
    {
        Paginator::useBootstrap();
        $query = $request->input('id');
        $resultados = Filme::where('id', 'like', '%' . $query . '%')->paginate(15);

        if ($resultados->count() > 0) {
            $filme = $resultados->first();


            return view('pesquisa.resultado_pesquisa', ['resultados' => $resultados]);
        } else {
            return redirect()->back()->with('error', 'Nenhum filme encontrado com esse título.');
        }
    }
}
