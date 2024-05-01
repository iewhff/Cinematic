@extends('layout.base')

@section('content')
    @foreach ($resultados as $resultado)
        <form action="/comprarBilhete" method="post">
            @csrf
            <div>
                <label for="nome">Nome:</label>
                <input id="nome" name="nome" value="{{ old('nome') }}">
                @error('nome_cliente')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="nif">NIF:</label>
                <input id="nif" name="nif" value="{{ old('nif') }}">
                @error('nif')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="ref_pagamento">Referencia de pagamento:</label>
                <input id="ref_pagamento" name="ref_pagamento" value="{{ old('ref_pagamento') }}">
                @error('ref_pagamento')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="tipo_pagamento">Tipo de pagamento:</label>
                <br>
                <input type="radio" name="opcao" value="valor2"> VISA
                <br>
                <input type="radio" name="opcao" value="valor3"> PayPal
                <br>
                <input type="radio" name="opcao" value="valor3"> MBWay
                @error('tipo_pagamento')
                    <span>{{ $message }}</span>
                @enderror
            </div>
            <input type="submit">
        </form>
    @endforeach
@endsection
