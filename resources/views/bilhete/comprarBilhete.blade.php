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

        <select name="lugaresDisponiveisTotal">
            @foreach ($lugaresDisponiveisTotal as $resultado)
                <option value="{{ $resultado->sessao_id }}-{{ $resultado->lugar_id }}">

                    {{ $resultado->data }} - {{ $resultado->horario_inicio }} - Sala {{ $resultado->sala_id }} - Fila

                    {{ $resultado->fila }} - Posição {{ $resultado->posicao }}

                </option>
            @endforeach

        </select>


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

        <div id="visaInputs" style="display: none;">
            <label for="visa_numero">Número do cartão VISA (16 dígitos):</label>
            <input type="text" id="visa_numero" name="visa_numero">
            <label for="visa_cvc">Código CVC (3 dígitos):</label>
            <input type="text" id="visa_cvc" name="visa_cvc">
        </div>

        <div id="paypalInputs" style="display: none;">
            <label for="paypal_email">Email do PayPal:</label>
            <input type="email" id="paypal_email" name="paypal_email">
        </div>

        <div id="mbwayInputs" style="display: none;">
            <label for="mbway_numero">Número do telemóvel (MBWay):</label>
            <input type="text" id="mbway_numero" name="mbway_numero">
        </div>


        <script>
            document.querySelectorAll('input[name="tipo_pagamento"]').forEach(function(radio) {
                radio.addEventListener('change', function() {
                    document.getElementById('visaInputs').style.display = 'none';
                    document.getElementById('paypalInputs').style.display = 'none';
                    document.getElementById('mbwayInputs').style.display = 'none';
                    if (this.value === 'visa') {
                        document.getElementById('visaInputs').style.display = 'block';
                    } else if (this.value === 'paypal') {
                        document.getElementById('paypalInputs').style.display = 'block';
                    } else if (this.value === 'mbway') {
                        document.getElementById('mbwayInputs').style.display = 'block';
                    }
                });
            });
        </script>

        <button type="submit" class="btn btn-primary">Comprar</button>
    </form>
@endsection
