@extends('layout.base')
@section('title', 'Perfil')
@section('content')


    @if (Auth::user()->foto_url)
        <div class="form-group">
            <img src="{{ Auth::user()->foto_url ? asset('storage/public/fotos/' . Auth::user()->foto_url) : asset('img/default_img.png') }}"
                alt="Foto do Utilizador" class="img-profile" style="max-width:100%">
        </div>
    @else
        <div class="form-group">
            <img src="{{ Auth::user()->foto_url ? asset('storage/public/fotos/' . Auth::user()->foto_url) : asset('img/default_img.png') }}"
                alt="Foto do Utilizador" class="img-profile" style="width:128px;height:128px">
        </div>
    @endif

    <div class="form-group">
        <label for="inputNome">Nome</label>
        <input type="text" class="form-control" value="{{ Auth::user()->name }}">
    </div>

    <div class="form-group">
        <label for="inputNome">Email</label>
        <input type="text" class="form-control" value="{{ Auth::user()->email }}">

    </div>

    <div class="form-group">
        <label for="inputNome">Tipo</label>

        @switch(Auth::user()->tipo)
            @case('A')
            <input type="text" class="form-control" value="Administrador">
            @break
            @case('F')
            <input type="text" class="form-control" value="Funcionario">
            @break
            @case('C')
            <input type="text" class="form-control" value="Cliente">
            @break

            @default

        @endswitch


    </div>


@endsection
