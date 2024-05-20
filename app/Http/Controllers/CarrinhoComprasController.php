<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessao;
use App\Models\Filme;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Lugar;
use Illuminate\Support\Facades\Session;

class CarrinhoComprasController extends Controller
{
    public function carrinhoCompras(Request $request)
    {

        if($request->input('id')){
            $this->adicionarCarrinho($request);
        }

        $title = 'Carrinho Compras';
        $totalFilmes = 0;
        $totalBilhetes = 0;
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
        $preco_bilhete = $configuracao->preco_bilhete_sem_iva * (1 + $configuracao->percentagem_iva / 100);
        $preco_bilhete = number_format($preco_bilhete, 2, '.', '');
        $precoTotal = $totalFilmes * $preco_bilhete;


        return view('carrinhoCompras.carrinhoCompras', compact('title', 'carrinho', 'filmes', 'precoTotal', 'preco_bilhete'));
    }

    public function adicionarCarrinho(Request $request)
    {

        $id = $request->input('id');
        // Inicializar o carrinho como um array se ainda não estiver definido
        $carrinho = session()->get('carrinho', []);

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
            $carrinho[] = $novoBilhete;  // Usar a sintaxe de array para adicionar ao carrinho
        }

        // Atualizar o carrinho na sessão
        session()->put('carrinho', $carrinho);

        return redirect()->back()->with('success', 'Itens adicionados ao carrinho com sucesso!');
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

        return redirect()->route('carrinhoCompras');
        // antes : return $this->carrinhoCompras(); isto NAO evitava o reenvio do formulario
    }

    public function removerTudoCarrinho()
    {
        session()->forget('carrinho');

        return redirect()->route('carrinhoCompras');
        // antes : return $this->carrinhoCompras(); isto NAO evitava o reenvio do formulario
    }

    public function limparCarrinho()
    {
        Session::forget('carrinho');
        return response()->json(['message' => 'Carrinho limpo com sucesso']);
    }
}
