@extends('layout.base')
@section('title', 'Perfil')
@section('content')

    @dump($errors)
    <form method="POST" action="{{ route('perfil.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

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
            <input type="text" name="name" class="form-control" value="{{ Auth::user()->name }}">
            @error('name')
                Falta Nome!!
            @enderror
        </div>

        <div class="form-group">
            <label for="inputNome">Email</label>
            <input type="text" name="email" class="form-control" value="{{ Auth::user()->email }}">
            @error('email')
                Falta Email!!
            @enderror

        </div>

        <div class="form-group">
            <label for="inputNome">Tipo</label>

            <select name="tipo" id="tipo_user" class="form-control">
                <option value="" disabled selected>Tipo de Utilizador</option>
                @foreach ($tipoUser as $tipoUtilizador => $label)
                    <option value="{{ $tipoUtilizador }}"
                        {{ old('tipo', Auth::user()->tipo) == $tipoUtilizador ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>


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
                        <option value="{{ $tipo }}"
                            {{ old('tipo_pagamento', Auth::user()->cliente->tipo_pagamento) == $tipo ? 'selected' : '' }}>
                            {{ $tipo }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="ref_pagamento">Referência de Pagamento</label>
                <input type="text" name="ref_pagamento" id="ref_pagamento" class="form-control"
                    placeholder="Referência de Pagamento"
                    value="{{ old('ref_pagamento', Auth::user()->cliente->ref_pagamento) }}">
            </div>


        @endif

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>

@endsection
