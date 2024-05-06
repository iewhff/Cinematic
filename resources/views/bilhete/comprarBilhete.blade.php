@extends('layout.base')

@section('content')
    <a href="{{ URL::previous() }}" class="btn btn-primary">Voltar</a>
    @foreach ($resultados as $resultado)
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Título:</strong> {{ $resultado->titulo }}</p>
                        <p><strong>Gênero:</strong> {{ $resultado->genero_code }}</p>
                        <p><strong>Ano:</strong> {{ $resultado->ano }}</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <img src="{{ asset('caminho/para/cartazes/' . $resultado->cartaz_url) }}"
                            alt="{{ $resultado->titulo }}" width="200">
                    </div>
                </div>
            </div>
        </div>
    @endforeach

    <form class="mt-4" action="/comprarBilhete" method="post">
        @csrf
        <div class="form-group">
            <label for="nome_cliente">Nome:</label>
            <input class="form-control" id="nome_cliente" name="nome_cliente" value="{{ old('nome_cliente') }}">
            @error('nome_cliente')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="nif">NIF:</label>
            <input class="form-control" id="nif" name="nif" value="{{ old('nif') }}">
            @error('nif')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="ref_pagamento">Referência de pagamento:</label>
            <input class="form-control" id="ref_pagamento" name="ref_pagamento" value="{{ old('ref_pagamento') }}">
            @error('ref_pagamento')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="tipo_pagamento">Tipo de pagamento:</label>
            <div>
                <input type="radio" id="visa" name="tipo_pagamento" value="visa">
                <label for="visa">VISA</label>
            </div>
            <div>
                <input type="radio" id="paypal" name="tipo_pagamento" value="paypal">
                <label for="paypal">PayPal</label>
            </div>
            <div>
                <input type="radio" id="mbway" name="tipo_pagamento" value="mbway">
                <label for="mbway">MBWay</label>
            </div>
        </div>
        @error('tipo_pagamento')
            <span class="text-danger">{{ $message }}</span>
        @enderror

        <p><strong>Preço:</strong> {{ $preco_bilhete }}</p>

        <button type="submit" class="btn btn-primary">Comprar</button>
    </form>
@endsection
