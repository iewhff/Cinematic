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

        return view('users.index', compact('users'));
    }

    public function show(User $user): View
    {
        return view('user.show')->with('user', $user);
    }


    public function edit(User $user): View
    {
        return view('user.edit')
            ->with('user', $user);
    }

    public function update(User $user, UserRequest $request): RedirectResponse
    {
        $user->update($request->all());
        return redirect()->route('user.index')
            ->with('alert-type', 'success');
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

}
