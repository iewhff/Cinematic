@extends('layout.base')

@section('content')
    <form class="mt-4" action="/comprarBilhete" method="post">
        @csrf
        <div class="form-group">
            <label for="nome">Nome:</label>
            <input class="form-control" id="nome" name="nome" value="{{ old('nome') }}">
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
                <input type="radio" id="paypal" name="tipo_pagamento" value="pyapal">
                <label for="paypal">PayPal</label>
            </div>
            <div>
                <input type="radio" id="mbway" name="tipo_pagamento" value="mbway">
                <label for="mbway">MBWay</label>
            </div>
            @error('tipo_pagamento')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
@endsection
