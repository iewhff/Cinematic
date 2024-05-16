<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;

class EditarFilmesController extends Controller
{
    public function index()
    {
        Paginator::useBootstrap();
        $filmes = Filme::paginate(20);
        $title = 'Editar Filmes';

        return view('filme.editarFilmes', compact('title','filmes'));
    }

    public function adicionarFilme()
    {
        $title = 'Adicionar Filme';

        return view('filme.adicionarFilme', compact('title'));
    }

    public function eliminarFilme(Request $request)
    {
        $title = 'Eliminar Filme';

        $id= $request->input('id');
        $filme = Filme::find($id);

        return view('filme.eliminar', compact('title','filme'));
    }

    public function editar(Request $request)
    {

        $id= $request->input('id');
        $filme = Filme::find($id);
        $title = 'Editar Filme';
        $editar = $request->input('editar');
        $inputText = $request->input('inputText');
        $editando = $request->input('editando');

        if ($editando == 'titulo') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'inputText' => 'required|string|max:255|min:1',
            ], [
                'inputText.required' => 'Título é obrigatório.',
            ]);

            DB::beginTransaction();

            try {

                // Atualize o título do filme
                // $filme->update([ //     'titulo' => $request->input('inputText'), // ]);

                    DB::table('filmes')->where('id', $id)
                    ->update(['titulo' => $inputText]);

                DB::commit();
                // Redireciona com uma mensagem de sucesso
                $id= $request->input('id');
                $filme = Filme::find($id);

                return view('filme.editar', compact('title','filme','editar'));

            } catch (\Exception $e) {
                DB::rollBack();
                $id= $request->input('id');
                $filme = Filme::find($id);
                // Redireciona com uma mensagem de erro
                return view('filme.editar', compact('title','filme','editar'));
            }
        }

        if ($editando == 'genero') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'inputText' => 'required|string|max:255|min:1',
            ], [
                'inputText.required' => 'Genero é obrigatório.',
            ]);

            DB::beginTransaction();

            try {
                // Encontre o filme pelo ID
                $filme = Filme::findOrFail($request->input('id'));

                // // Atualize o título do filme
                // $filme->update([
                //     'genero_code' => $request->input('inputText'),
                // ]);

                DB::table('filmes')->where('id', $id)
                    ->update(['genero_code' => $inputText]);


                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return view('filme.editar', compact('title','filme','editar'));
            }
        }


        if ($editando == 'ano') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'inputText' => 'required|string|max:255|min:1',
            ], [
                'inputText.required' => 'Ano é obrigatório.',
            ]);

            DB::beginTransaction();

            try {
                // Encontre o filme pelo ID
                $filme = Filme::findOrFail($request->input('id'));

                // Atualize o título do filme
                // $filme->update([
                //     'ano' => $request->input('inputText'),
                // ]);

                DB::table('filmes')->where('id', $id)
                    ->update(['ano' => $inputText]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return view('filme.editar', compact('title','filme','editar'));
            }
        }

        if ($editando == 'sumario') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'inputText' => 'required|string|max:255|min:10',
            ], [
                'inputText.required' => 'Sumario é obrigatório.',
            ]);

            DB::beginTransaction();

            try {
                // Encontre o filme pelo ID
                $filme = Filme::findOrFail($request->input('id'));

                // Atualize o título do filme
                // $filme->update([
                //     'sumario' => $request->input('inputText'),
                // ]);

                DB::table('filmes')->where('id', $id)
                ->update(['sumario' => $inputText]);

                DB::commit();

            } catch (\Exception $e) {
                return view('filme.editar', compact('title','filme','editar'));
            }
        }

        if ($editando == 'url') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'inputText' => 'required|string|max:255|min:10',
            ], [
                'inputText.required' => 'Url do trailer é obrigatório.',
            ]);

            DB::beginTransaction();

            try {
                // Encontre o filme pelo ID
                $filme = Filme::findOrFail($request->input('id'));

                // Atualize o título do filme
                // $filme->update([
                //     'trailer_url' => $request->input('inputText'),
                // ]);

                DB::table('filmes')->where('id', $id)
                ->update(['trailer_url' => $inputText]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return view('filme.editar', compact('title','filme','editar'));
            }
        }


        if ($request->input('editando') == 'cartaz_url') {
            $request->validate([
                'id' => 'required|exists:filmes,id', // Verifica se o ID existe na tabela 'filmes'
                'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            ], [
                'image.required' => 'Imagem é obrigatória.',
                'id.required' => 'ID é obrigatório.',
                'id.exists' => 'O ID informado não existe.',
            ]);

            DB::beginTransaction();

            try {
                // Encontre o filme pelo ID
                $filme = Filme::findOrFail($request->input('id'));

                // Gere o nome da imagem com underscores no lugar dos espaços
                $imageName = str_replace(' ', '_', $filme->titulo) . '.jpg';

                // Mova a imagem para o local especificado
                $request->file('image')->move(public_path('imgs/cartazes'), $imageName);

                // Atualize o campo 'cartaz_url' do filme
                $filme->update(['cartaz_url' => $imageName]);

                DB::commit();

                // Redirecione para uma página de sucesso ou faça outra ação desejada
                return redirect()->route('filmes.index')->with('success', 'Cartaz atualizado com sucesso!');
            } catch (\Exception $e) {
                DB::rollBack();

                // Log de erro para depuração
                Log::error('Erro ao atualizar cartaz do filme: ' . $e->getMessage());

                // Redirecione de volta com uma mensagem de erro
                return redirect()->back()->with('error', 'Erro ao atualizar o cartaz. Por favor, tente novamente.');
            }
        }



        return view('filme.editar', compact('title','filme','editar'));
    }

    public function adicionar(Request $request)
    {
        // Validação do recibo
        $request->validate([
            'titulo' => 'required',
            'genero_code' => 'required|string|max:55',
            'ano' => 'required|numeric|digits:4',
            'cartaz_url' => 'required|string|max:500',
            'sumario' => 'required|string|max:250',
            'trailer_url' => 'required|string|max:550',
        ], [
            'titulo.required' => 'Titulo é obrigatório.',
            'genero_code.required' => 'Nao sei como o fez, mas o Genero é obrigatório.',
            'ano.required' => 'Ano é obrigatório.',
            'cartaz_url.required' => 'Cartaz é obrigatório.',
            'sumario.required' => 'Sumario é obrigatório.',
            'trailer_url.required' => 'Trailer é obrigatório.',
        ]);

        DB::beginTransaction();

        try {
            Filme::create([
                'titulo' => $request->input('titulo'),
                'genero_code' => $request->input('genero_code'),
                'ano' => $request->input('ano'),
                'cartaz_url' => $request->input('cartaz_url'),
                'sumario' => $request->input('sumario'),
                'trailer_url' => $request->input('trailer_url'),
            ]);

            DB::commit();

            // Redireciona com uma mensagem de sucesso
            return redirect()->route('editarFilmes')->with('success', 'Filme adicionado com sucesso.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Redireciona com uma mensagem de erro
            return redirect()->route('editarFilmes')->with('error', 'Ocorreu um erro ao adicionar o filme.');
        }
    }

    public function eliminar(Request $request)
    {
        // Validação do recibo
        $request->validate([
            'id' => 'required|exists:filmes,id',

        ]);

        DB::beginTransaction();

        try {
            DB::table('filmes')->where('id', $request->input('id'))->delete();

            DB::commit();

            // Redireciona com uma mensagem de sucesso
            return redirect()->route('editarFilmes')->with('success', 'Filme eliminado.');

        } catch (\Exception $e) {
            DB::rollBack();

            // Redireciona com uma mensagem de erro
            return redirect()->route('editarFilmes')->with('error', 'Ocorreu um erro ao eliminar o filme.');
        }
    }



}
