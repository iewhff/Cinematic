<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Filme;
use App\Models\Genero;
use Illuminate\Pagination\Paginator;


class FilmeController extends Controller
{

    public function index(Request $request)
    {
        if (isset($request) && $request->input('code') != null) {
            $opcoes = Genero::all(); // Recupera todas as opções do banco de dados
            Paginator::useBootstrap();

            $query = $request->input('code');

            // Consulta os filmes com base no 'genero_id'
            $filmes = Filme::where('genero_code', $query)->paginate(15);

            return view('filme.filmes', compact('filmes', 'opcoes'));
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

            // Verifica se o filme foi encontrado
            if ($filme) {
                // Se o filme foi encontrado, retorna a view com os detalhes do filme
                return view('filme.detalhes', ['filme' => $filme]);
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
}
