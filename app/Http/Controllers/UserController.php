<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\View\View;
use App\Http\Requests\UserRequest;

class UserController extends Controller
{
    public function index(): View
    {

        

        Paginator::useBootstrap();
        $users = User::paginate(15);

        return view('users.index', compact('users','tipoUser'));
    }

    public function create()
    {
        $tipoUser = User::$tipoUser;
        return view('users.create', compact('tipoUser'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'tipo' => 'required|string|in:A,F',
        ]);

        $user = User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => bcrypt($validatedData['password']),
            'tipo' => $validatedData['tipo'],
        ]);

        return redirect()->route('users')->with('success', 'Utilizador criado com sucesso.');
    }

    public function show(User $user): View
    {
        return view('user.show')->with('user', $user);
    }


    public function edit(User $user): View
    {
        $tipoUser = User::$tipoUser;
        return view('user.edit', compact('user', 'tipoUser'));
    }

//dawdawdawdawdadawwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwwww
public function editUpdate($id, UserRequest $request): RedirectResponse
    {
        $user = User::findOrFail($id);
        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required','string','email','max:255', Rule::unique('users')->ignore($user->id),
            ],
            'tipo' => 'required',
        ]);

        // Atualização dos dados do usuário
        $user->update($request->only(['name','email','tipo']));

        return redirect()->route('user.edit', $user)->with('success', 'Utilizador atualizado com sucesso.');
    }

    public function uploadImage(Request $request, User $user)
    {

        if ($request->hasFile('image')) {
            $image = $request->file('image');

            $filename = $user->id . "_" . uniqid() . '.' . $image->extension();
            $image->storeAs('public/fotos', $filename);

            $user->save(['foto_url' => $filename,]);
        }

        return redirect()->back()
            ->with('success', 'Image uploaded successfully!');
    }

    public function softDelete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }

        $user->delete();

        return redirect()->route('user.index')->with('success', 'User soft deleted successfully.');
    }

    public function search(UserRequest $request , User $user)
    {
        $request->all();
        $lili = request('pesquisa');
        if ($request) {
            $filmeSearched = User::where('name', 'LIKE', "%$lili%")->get();
        } else {
            return redirect()->route("user.index");
        }

        return view('user.index')
                ->with('users', $filmeSearched);
    }



    public function alterarTipo(User $user, UserRequest $request): RedirectResponse
    {

        $lili = request('alterType');

        $user->tipo = $lili;
        $user->update($request->all());


        return view('user.index')
                ->with('user', $users);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        //dump($user); die();

        // Validação dos dados
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'tipo' => 'required',
            'nif' => 'nullable|string|max:15',
            'tipo_pagamento' => 'nullable|string|max:50',
        ]);

        // Atualização dos dados do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->tipo = $request->tipo;

        if ($user->tipo == 'C') {
            $user->cliente->nif = $request->nif;
            $user->cliente->tipo_pagamento = $request->tipo_pagamento;
            $user->cliente->save();
        }

        $user->save();

        return redirect()->route('perfil')->with('success', 'Perfil atualizado com sucesso.');
    }

    public function block(User $user)
    {
        $user->bloqueado = 1;
        $user->save();

        return redirect()->route('users')->with('success', 'Usuário bloqueado com sucesso.');
    }

    public function unblock(User $user)
    {
        $user->bloqueado = 0;
        $user->save();

        return redirect()->route('users')->with('success', 'Usuário desbloqueado com sucesso.');
    }

}
