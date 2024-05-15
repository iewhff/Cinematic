<?php

namespace App\Http\Controllers;

use App\Models\Filme;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\DB;

class EditarFilmesController extends Controller
{
    public function index()
    {
        Paginator::useBootstrap();
        $filmes = Filme::paginate(20);
        $title = 'Editar Filmes';

        return view('filme.editarFilmes', compact('title','filmes'));
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
                $filme->update([
                    'titulo' => $request->input('inputText'),
                ]);

                DB::commit();
                // Redireciona com uma mensagem de sucesso
                return redirect()->route('editar')->with('success', 'Título atualizado com sucesso.');

            } catch (\Exception $e) {
                DB::rollBack();
                // Redireciona com uma mensagem de erro
                return redirect()->route('editar')->with('error', 'Ocorreu um erro ao atualizar o título.');
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

                // Atualize o título do filme
                $filme->update([
                    'genero_code' => $request->input('inputText'),
                ]);

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
                $filme->update([
                    'ano' => $request->input('inputText'),
                ]);

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
                $filme->update([
                    'sumario' => $request->input('inputText'),
                ]);

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
                $filme->update([
                    'trailer_url' => $request->input('inputText'),
                ]);

                DB::commit();

            } catch (\Exception $e) {
                DB::rollBack();
                return view('filme.editar', compact('title','filme','editar'));
            }
        }


        return view('filme.editar', compact('title','filme','editar'));
    }
}
