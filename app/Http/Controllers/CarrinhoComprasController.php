<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sessao;
use App\Models\Filme;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Lugar;

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
        $preco_bilhete = $configuracao->preco_bilhete_sem_iva * 0.1 * $configuracao->percentagem_iva;
        $preco_bilhete = number_format($preco_bilhete, 2, '.', '');
        $precoTotal = $totalFilmes * $preco_bilhete;


        return view('carrinhoCompras.carrinhoCompras', compact('title', 'carrinho', 'filmes', 'precoTotal', 'preco_bilhete'));
    }

    public function adicionarCarrinho(Request $request)
    {
        $id = $request->input('id');  // Suponho que $id seja o filme_id ou algum identificador do item a ser adicionado
        $nmrLugares = $request->input('quantity', 1);  // Número de lugares selecionados pelo usuário, com valor padrão de 1

        // Obter todas as sessões do filme especificado
        $sessoes = Sessao::where('filme_id', $id)->get();

        // Obter todos os sala_id das sessões
        $salaIds = $sessoes->pluck('sala_id');

        // Obter todos os lugares que têm um sala_id correspondente
        $lugares = Lugar::whereIn('sala_id', $salaIds)
                        ->select('fila', 'posicao')
                        ->get();

        // Inicializar o carrinho como um array se ainda não estiver definido
        $carrinho = session()->get('carrinho', []);

        for ($i = 0; $i < $nmrLugares; $i++) {
            if (isset($lugares[$i])) {
                $lugar = $lugares[$i];
                $naoExisteNoCarrinho = true;

                // Verificar se o item já existe no carrinho pelo ID e lugar
                foreach ($carrinho as $item) {
                    if (isset($item['lugar']) && $item['id'] == $id && $item['lugar']['fila'] == $lugar->fila && $item['lugar']['posicao'] == $lugar->posicao) {
                        $naoExisteNoCarrinho = false;
                        break;
                    }
                }

                // Se o item não existe no carrinho, adiciona o novo item
                if ($naoExisteNoCarrinho) {
                    // Adiciona o novo item ao carrinho
                    $novoBilhete = ['id' => $id, 'lugar' => ['fila' => $lugar->fila, 'posicao' => $lugar->posicao]];
                    $carrinho[] = $novoBilhete;  // Usar a sintaxe de array para adicionar ao carrinho
                }
            }
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
}
