<?php



namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use App\Models\Filme;
use Illuminate\Pagination\Paginator;


class FilmeController extends Controller
{

    public function index()
    {
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



        return view('filme.filmes', compact('filmes', 'title', 'imagens'));

        //return view('disciplina.index', ['ds' => $disciplinas]); // Passando a variável $disciplinas para a view
        //tambem poderia ser assim: return view('disciplina.index', compact('disciplinas'));
        //, neste caso a variavel $disciplinas do controlador e na view vai ter o mesmo nome
    }
}
