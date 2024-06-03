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

    <br>

    @if (Auth::user()->tipo == 'C')
        <h4 class="mb-4 font-semibold text-gray-600 dark:text-gray-300">
            Dados de pagamento
        </h4>

        <div class="form-group">
            <label for="nif">NIF</label>
            <input type="text" name="nif" id="nif" class="form-control" placeholder="NIF"
                value="{{ old('nif', Auth::user()->cliente->nif) }}">
        </div>

        <div class="form-group">
            <label for="tipo_pagamento">Tipo de Pagamento</label>
            <select name="tipo_pagamento" id="tipo_pagamento" class="form-control">
                <option value="" disabled selected>Selecione o tipo de pagamento</option>
                @foreach ($tipoPagamentos as $tipo)
                    <option value="{{ $tipo }}" {{ old('tipo_pagamento', Auth::user()->cliente->tipo_pagamento) == $tipo ? 'selected' : '' }}>
                        {{ $tipo }}
                    </option>
                @endforeach
            </select>
        </div>


    @endif

@endsection
