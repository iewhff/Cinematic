@extends('layout.base')

@section('title', $title)

@section('content')

    @if (isset($bilhetes) && $bilhetes->count() > 0)

        @foreach ($bilhetes as $item)
            <div class="card">
                <div class="card-body">
                    {{-- Verificar se a sessão está presente --}}
                    @if ($item->sessao)
                        {{-- Verificar se o filme está presente --}}
                        @if ($item->sessao->filme)
                            <h5 class="card-title">{{ $item->sessao->filme->titulo }}</h5>
                        @else
                            <h5 class="card-title">Filme não disponível</h5>
                        @endif

                        {{-- Verificar se o horário de início da sessão está presente --}}
                        <p class="card-text">O filme começa às: {{ $item->sessao->horario_inicio }}</p>
                        {{-- Verificar se o horário de início da sessão está presente --}}
                        <p class="card-text">Dia: {{ $item->sessao->data }}</p>

                        {{-- Verificar se a sala está presente --}}
                        @if ($item->sessao->sala)
                            <p class="card-text">Sala: {{ $item->sessao->sala->nome }}</p>
                            <p class="card-text">Lugar: {{ $item->lugar->fila }}{{ $item->lugar->posicao }}</p>
                        @else
                            <p class="card-text">Sala não disponível</p>
                        @endif
                    @else
                        <h5 class="card-title">Sessão não disponível</h5>
                    @endif

                    <a href="{{ route('downloadBilhetePdf', ['id' => $item->id]) }}" class="btn btn-primary">Download
                        Bilhete</a>
                    <a href="{{ route('downloadReciboPdf', ['id' => $item->id]) }}" class="btn btn-primary">Download
                        Recibo</a>

                </div>
            </div>
        @endforeach
    @else
        <p>Não há bilhetes disponíveis.</p>

    @endif

@endsection
