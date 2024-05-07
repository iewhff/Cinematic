<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\Sessao;

class PesquisaController extends Controller
{
    public function pesquisa(Request $request)
    {
        Paginator::useBootstrap();
        $query = $request->input('titulo'); // Alterado para buscar pelo campo 'titulo' em vez de 'id'

        // Realiza a consulta utilizando o operador 'like' para encontrar correspondências parciais no título
        $resultados = Filme::where('titulo', 'like', '%' . $query . '%')->paginate(15);

        $dataAtual = Carbon::now()->toDateString();

        foreach ($resultados as $resultado) {
            // Verificar se existem registros na tabela sessoes com data igual a hoje ou posterior e com o filme_id especificado
            $existeSessao = Sessao::where('filme_id', $resultado->id)
                ->whereDate('data', '>=', $dataAtual)
                ->exists();

            // Adicionar a informação sobre a existência de sessões ao filme atual
            $resultado->existeSessao = $existeSessao;
        }

        if ($resultados->count() > 0) {
            // Retorna a visualização com os resultados paginados
            return view('pesquisa.resultado_pesquisa', ['existeSessao' => $existeSessao, 'resultados' => $resultados]);
        } else {
            // Redireciona de volta com uma mensagem de erro se nenhum filme for encontrado
            return redirect()->back()->with('error', 'Nenhum filme encontrado com esse título.');
        }
    }
}
