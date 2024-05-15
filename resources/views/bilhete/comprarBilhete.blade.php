@extends('layout.base')

@section('title', $title)

@section('content')
<a href="/carrinhoCompras" class="btn btn-primary">Voltar</a>
<p>Se escolher outros lugares, tenha em atenção em não ter os mesmos lugares repetidos. Os lugares repetidos não serão comprados, o que resultara numa compra com menos bilhetes do que os selecionados.</p>
<form class="mt-4" action="/comprarBilhete" method="POST">
    @php
        $nrLugar = -1;
    @endphp
    @foreach ($resultados as $resultado)
    @php
        $nrLugar++;
    @endphp
        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        <p><strong>Título:</strong> {{ $resultado['filme']->titulo }}</p>
                        <p><strong>Gênero:</strong> {{ $resultado['filme']->genero_code }}</p>
                        <p><strong>Ano:</strong> {{ $resultado['filme']->ano }}</p>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <img src="{{ asset('caminho/para/cartazes/' . $resultado['filme']->cartaz_url) }}"
                            alt="{{ $resultado['filme']->titulo }}" width="200">
                    </div>
                </div>
            </div>
        </div>


        <select name="lugar{{ $nrLugar}}">
            @for ($i = $nrLugar; $i < $resultado['lugaresDisponiveisTotal']->count(); $i++)
                <option value="{{ $resultado['lugaresDisponiveisTotal'][$i]->sessao_id }}-{{ $resultado['lugaresDisponiveisTotal'][$i]->lugar_id }}">
                    {{ $resultado['lugaresDisponiveisTotal'][$i]->data }} - {{ $resultado['lugaresDisponiveisTotal'][$i]->horario_inicio }} - Sala {{ $resultado['lugaresDisponiveisTotal'][$i]->sala_id }} - Fila {{ $resultado['lugaresDisponiveisTotal'][$i]->fila }} - Posição {{ $resultado['lugaresDisponiveisTotal'][$i]->posicao }}
                </option>

            @endfor
            {{-- @foreach ($resultado['lugaresDisponiveisTotal'] as $lugar)
                <option value="{{ $lugar->sessao_id }}-{{ $lugar->lugar_id }}">
                    {{ $lugar->data }} - {{ $lugar->horario_inicio }} - Sala {{ $lugar->sala_id }} - Fila {{ $lugar->fila }} - Posição {{ $lugar->posicao }}
                </option>
            @endforeach --}}
        </select>
        @endforeach
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

        <div id="visaInputs" style="display: none;">
            <label for="visa_numero">Número do cartão VISA (16 dígitos):</label>
            <input type="text" id="visa_numero" name="visa_numero">
            @error('visa_numero')
            <span class="text-danger">{{ $message }}</span>
            @enderror
            <label for="visa_cvc">Código CVC (3 dígitos):</label>
            <input type="text" id="visa_cvc" name="visa_cvc">
            @error('visa_cvc')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div id="paypalInputs" style="display: none;">
            <label for="paypal_email">Email do PayPal:</label>
            <input type="email" id="paypal_email" name="paypal_email">
            @error('paypal_email')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div id="mbwayInputs" style="display: none;">
            <label for="mbway_numero">Número do telemóvel (MBWay):</label>
            <input type="text" id="mbway_numero" name="mbway_numero">
            @error('mbway_numero')
            <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <input type="hidden" name="nrBilhetes" value="{{ count($resultados) }}">


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
