@extends('layout.base')

@section('title', $title)

@section('content')

<h1>Lugares da Sessão</h1>

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form action="{{ route('comprarBilhete') }}" method="GET" id="lugaresForm">
    @csrf

    @php
        $currentFila = null;
    @endphp

    @foreach ($lugares as $lugar)
        @if ($currentFila !== $lugar->fila)
            @if ($currentFila !== null)
                </div> <!-- Fechar a div anterior da fila -->
            @endif
            @php
                $currentFila = $lugar->fila;
            @endphp
            <div class="mb-3">
                <strong>Fila {{ $lugar->fila }}:</strong><br>
        @endif
        <div class="form-check form-check-inline">
            <img src="{{ asset('imgs/cadeira/cadeira-preta.svg') }}" class="cadeira {{ $lugar->ocupado ? 'ocupado' : '' }}" data-fila="{{ $lugar->fila }}" data-posicao="{{ $lugar->posicao }}"  data-id="{{ $lugar->id }}"  alt="Cadeira">
            <div>{{ $lugar->posicao }}</div>
        </div>
    @endforeach

    @if ($currentFila !== null)
        </div> <!-- Fechar a última div da fila -->
    @endif

    <button type="submit" class="btn btn-primary mt-3">Confirmar Lugares</button>
    <input type="hidden" name="filmeId" value="{{ $filmeId }}">
    <input type="hidden" name="sessaoId" value="{{ $sessaoId }}">
</form>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const cadeiras = document.querySelectorAll('.cadeira');

        cadeiras.forEach(cadeira => {
            if (!cadeira.classList.contains('ocupado')) {
                cadeira.addEventListener('click', function () {
                    const fila = this.getAttribute('data-fila');
                    const posicao = this.getAttribute('data-posicao');
                    const lugarId = this.getAttribute('data-id');

                    if (this.classList.contains('selected')) {
                        this.classList.remove('selected');
                        document.querySelector(`input[value="${lugarId}"]`).remove();
                    } else {
                        this.classList.add('selected');
                        const input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'lugares[]';
                        input.value = lugarId;
                        document.getElementById('lugaresForm').appendChild(input);
                    }
                });
            }
        });
    });
</script>

<style>
.cadeira {
    width: 30px;
    cursor: pointer;
    border-radius: 5px; /* Adiciona cantos arredondados */
}

.ocupado {
    opacity: 0.5;
    cursor: not-allowed;
    background-color: red;
    border-radius: 5px; /* Adiciona cantos arredondados */
}

.selected {
    background-color: green;
    border: 2px solid green;
    border-radius: 5px; /* Adiciona cantos arredondados */
}
</style>


@endsection
