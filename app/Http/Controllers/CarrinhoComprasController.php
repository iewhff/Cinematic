<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessao;
use App\Models\Filme;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CarrinhoComprasController extends Controller
{
    public function carrinhoCompras()
    {
        $title = 'Carrinho Compras';
        $totalFilmes = 0;
        $filmes = [];
        $dataAtual = Carbon::now()->toDateString(); // Obtém a data atual
        $lugaresDisponiveisTotal = [];
        // Inicializar o carrinho como um array se ainda não estiver definido
        $carrinho = session('carrinho', []);
        foreach ($carrinho as $key => $item) {
            $filme = Filme::find($item['id']);
            if ($filme) {
                $totalFilmes++;
                // Obtenha os lugares disponíveis para o filme atual
                $lugaresDisponiveisTotal = DB::table('sessoes')
                    ->join('lugares', 'sessoes.sala_id', '=', 'lugares.sala_id')
                    ->leftJoin('bilhetes', function ($join) {
                        $join->on('sessoes.id', '=', 'bilhetes.sessao_id')
                            ->on('lugares.id', '=', 'bilhetes.lugar_id');
                    })
                    ->select('sessoes.id as sessao_id', 'sessoes.data', 'sessoes.horario_inicio', 'sessoes.sala_id', 'lugares.id as lugar_id', 'lugares.fila', 'lugares.posicao')
                    ->where('sessoes.filme_id', $item['id'])
                    ->whereDate('sessoes.data', '>=', $dataAtual)
                    ->whereNull('bilhetes.lugar_id')
                    ->get();

                // Adicione o filme e os lugares disponíveis ao vetor $filmes
                $filmes[] = [
                    'filme' => $filme,
                    'lugaresDisponiveisTotal' => $lugaresDisponiveisTotal
                ];
            }
        }


        $resultados = DB::select('SELECT * FROM configuracao');
        $configuracao = $resultados[0];
        $preco_bilhete = $configuracao->preco_bilhete_sem_iva * 0.1 * $configuracao->percentagem_iva;
        $preco_bilhete = number_format($preco_bilhete, 2, '.', '');
        $precoTotal = $totalFilmes * $preco_bilhete;


        return view('carrinhoCompras.carrinhoCompras', compact('title', 'carrinho', 'filmes', 'precoTotal', 'preco_bilhete'));
    }

    public function adicionarCarrinho(Request $request)
    {
        // Obtém o valor do parâmetro 'id' da requisição
        $id = $request->input('id');

        // Verifica se o parâmetro 'id' foi fornecido
        if ($id) {
            // Consulta o filme com base no 'id'
            $filme = Filme::find($id);

            // Verifica se o filme foi encontrado
            if ($filme) {

                // Obter a data atual
                $dataAtual = Carbon::now()->toDateString();

                // Verificar se existem registros na tabela sessoes com data igual a hoje ou posterior e com o filme_id especificado
                $existeSessao = Sessao::where('filme_id', $id)
                    ->whereDate('data', '>=', $dataAtual)
                    ->exists();

                // Inicializar o carrinho como um array se ainda não estiver definido
                $carrinho = session()->get('carrinho', []);

                // Verificar se o item já existe no carrinho pelo ID
                $naoExisteNoCarrinho = true;
                foreach ($carrinho as $item) {
                    if ($item['id'] == $id) {
                        $naoExisteNoCarrinho = false;
                        break;
                    }
                }

                // Se o item não existe no carrinho, adiciona o novo item
                if ($naoExisteNoCarrinho) {
                    // Adiciona o novo item ao carrinho
                    $novoBilhete = ['id' => $id];
                    session()->push('carrinho', $novoBilhete);
                }


                // Se o filme foi encontrado, retorna a view com os detalhes do filme
                return view('filme.detalhes', ['existeSessao' => $existeSessao, 'filme' => $filme]);
            } else {
                // Se o filme não foi encontrado, redireciona de volta com uma mensagem de erro
                return redirect()->back()->with('error', 'Nenhum filme encontrado com esse ID.');
            }
        } else {
            // Se o parâmetro 'id' não foi fornecido, redireciona de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'ID do filme não fornecido.');
        }
    }

    public function removerCarrinho(Request $request)
    {

        $id = $request->input('idRemover');
        // Inicializar o carrinho como um array se ainda não estiver definido
        $carrinho = session()->get('carrinho', []);

        // Verificar se o item existe no carrinho pelo ID
        foreach ($carrinho as $index => $item) {
            if ($item['id'] == $id) {
                // Remover o item do array 'carrinho' usando o método pull
                $request->session()->forget('carrinho.' . $index);
                break; // O item foi removido, então podemos sair do loop
            }
        }


        // Se o item não existe no carrinho, adiciona o novo ite

        return $this->carrinhoCompras();
    }
}
