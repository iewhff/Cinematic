@extends('layout.base')

@section('title', $title)

@section('content')

    @if (isset($bilhete) && $bilhete->count() > 0)
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">{{ $bilhete->sessao->filme->titulo }}</h5>
                <p class="card-text">O filme começa às: {{ $bilhete->sessao->horario_inicio }}</p>
                <p class="card-text">{{ $bilhete->preco_sem_iva }}€</p>
                <p class="card-text">Sala: {{ $bilhete->sessao->sala->nome }}</p>
                <p class="card-text">Lugar: {{ $bilhete->lugar->fila }}{{ $bilhete->lugar->posicao }}</p>
                <a href="{{ route('bilhetes.mostrar', ['id' => $bilhete->id]) }}" class="btn btn-primary">Download</a>
            </div>
        </div>
    @endif


@endsection
