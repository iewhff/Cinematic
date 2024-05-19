<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Genero;
use Illuminate\Pagination\Paginator;
use Carbon\Carbon;
use App\Models\Sessoes;
use App\Models\Sessao;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FilmeController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request) && $request->input('code') != null) {
            $opcoes = Genero::all(); // Recupera todas as opções do banco de dados
            Paginator::useBootstrap();

            $query = $request->input('code');
            $title = 'Filmes';
            // Consulta os filmes com base no 'genero_id'
            $filmes = Filme::where('genero_code', $query)->paginate(15);

            return view('filme.filmes', compact('filmes', 'title', 'opcoes'));
        } else {
            $opcoes = Genero::all(); // Recupera todas as opções do banco de dados
            Paginator::useBootstrap();
            $filmes = Filme::paginate(20);

            $title = 'Filmes';

            $directory = storage_path('app/public/imagens');
            $files = Storage::files($directory);

            $imagens = new Collection();

            foreach ($files as $file) {
                $path = storage_path('app/public/cartazes' . $file);
                $imagem = file_get_contents($path);
                $nomeFicheiro = basename($file);

                $imagens[] = [
                    'nomeFicheiro' => $nomeFicheiro,
                    'imagem' => $imagem
                ];
            }



            return view('filme.filmes', compact('filmes', 'title', 'imagens', 'opcoes'));

            //return view('disciplina.index', ['ds' => $disciplinas]); // Passando a variável $disciplinas para a view
            //tambem poderia ser assim: return view('disciplina.index', compact('disciplinas'));
            //, neste caso a variavel $disciplinas do controlador e na view vai ter o mesmo nome
        }
    }

    public function detalhes(Request $request)
    {
        // Obtém o valor do parâmetro 'id' da requisição
        $id = $request->input('id');


        // Verifica se o parâmetro 'id' foi fornecido
        if ($id) {
            // Consulta o filme com base no 'id'
            $filme = Filme::find($id);
            $title = $filme->titulo;
            // Verifica se o filme foi encontrado
            if ($filme) {

                // Obter a data atual
                $dataAtual = Carbon::now()->toDateString();

                // Verificar se existem registros na tabela sessoes com data igual a hoje ou posterior e com o filme_id especificado
                $existeSessao = Sessao::where('filme_id', $id)
                    ->whereDate('data', '>=', $dataAtual)
                    ->exists();


                // Se o filme foi encontrado, retorna a view com os detalhes do filme
                return view('filme.detalhes', [
                    'title' => $title,
                    'existeSessao' => $existeSessao,
                    'filme' => $filme
                ]);
            } else {
                // Se o filme não foi encontrado, redireciona de volta com uma mensagem de erro
                return redirect()->back()->with('error', 'Nenhum filme encontrado com esse ID.');
            }
        } else {
            // Se o parâmetro 'id' não foi fornecido, redireciona de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'ID do filme não fornecido.');
        }
    }

    public function filtro(Request $request)
    {
    }

    public function welcome(Request $request)
    {
        // Obter a data e hora atual
        $dataAtual = Carbon::now()->toDateString();
        $horaAtual = Carbon::now()->toTimeString();
        // Obter os sessao_id baseado no cliente_id
        $sessaoIds = DB::table('bilhetes')
            ->where('cliente_id', Auth::user()->id)
            ->pluck('sessao_id');

        // Verificar se encontrou algum resultado
        if ($sessaoIds->isEmpty()) {
            $filmes=[];
        } else {
            // Obter os gêneros mais frequentes para as sessões do cliente
            $topGeneros = DB::table('sessoes')
                ->join('filmes', 'sessoes.filme_id', '=', 'filmes.id')
                ->select('filmes.genero_code', DB::raw('count(*) as total'))
                ->whereIn('sessoes.id', $sessaoIds)
                ->groupBy('filmes.genero_code')
                ->orderByDesc('total')
                ->limit(5)
                ->get()
                ->pluck('genero_code') // Pluck to get an array of genero_code
                ->toArray();


            // Obter os filmes que atendem aos critérios
            $filmes = DB::table('filmes')
                ->join('sessoes', 'filmes.id', '=', 'sessoes.filme_id')
                ->select('filmes.*') // Seleciona todas as colunas da tabela filmes
                ->whereIn('filmes.genero_code', $topGeneros)
                ->whereDate('sessoes.data', '>=', $dataAtual)
                ->whereTime('sessoes.horario_inicio', '>', $horaAtual)
                ->distinct()
                ->get();


        }

         // Consulta para obter os top 5 filmes com base no número de bilhetes vendidos, com sessões a partir de hoje
         $topFilmes = DB::table('filmes')
         ->join('sessoes', 'filmes.id', '=', 'sessoes.filme_id')
         ->join('bilhetes', 'sessoes.id', '=', 'bilhetes.sessao_id')
         ->select('filmes.*', DB::raw('COUNT(bilhetes.id) as total_bilhetes'))
         ->whereDate('sessoes.data', '>=', $dataAtual)
         ->whereTime('sessoes.horario_inicio', '>=', $horaAtual)
         ->groupBy('filmes.id')
         ->orderByDesc('total_bilhetes')
         ->limit(5)
         ->get();

        // O título da página
        $title = 'Filmes';
        return view('filme.sessoes', compact('filmes','topFilmes', 'title'));
    }

    
    public function show(Request $request)
    {
        $dataHoje = Carbon::now();
        $dataAmanha = Carbon::tomorrow();
        $title = 'Sessoes abertas';
        $opcoes = Genero::all();

        $directory = storage_path('app/public/imagens');
        $files = Storage::files($directory);

        $imagens = new Collection();

        foreach ($files as $file) {
            $path = storage_path('app/public/cartazes' . $file);
            $imagem = file_get_contents($path);
            $nomeFicheiro = basename($file);

            $imagens[] = [
                'nomeFicheiro' => $nomeFicheiro,
                'imagem' => $imagem
            ];
        }

        $sessoes = Sessao::whereDate('data', '>=', $dataHoje)
            ->whereDate('data', '<=', $dataAmanha)
            ->get();

        $emExibicao = Filme::whereIn('id', $sessoes->pluck('filme_id'))
            ->paginate(4);



        return view('filme.sessoes')->with('filmes', $emExibicao)->with('title', $title)->with('opcao', $opcoes)->with('imagens');
    }
}