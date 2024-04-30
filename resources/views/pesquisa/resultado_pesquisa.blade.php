@extends('layout.base')
@extends('css.tabela')

@section('content')
    @foreach ($resultados as $resultado)
        <p><strong>ID:</strong> {{ $resultado->id }}</p>

        <p><strong>Título:</strong> {{ $resultado->titulo }}</p>

        <p><strong>Gênero:</strong> {{ $resultado->genero_code }}</p>

        <p><strong>Ano:</strong> {{ $resultado->ano }}</p>

        <p><strong>Cartaz:</strong> <img src="{{ asset('caminho/para/cartazes/' . $resultado->cartaz_url) }}"
                alt="{{ $resultado->titulo }}" width="200"></p>

        <p><strong>Sumário:</strong> {{ $resultado->sumario }}</p>

        <p><strong>Trailer:</strong> <a href="{{ $resultado->trailer_url }}" target="_blank">Assistir ao Trailer</a></p>

        <p><strong>Criado em:</strong> {{ $resultado->created_at }}</p>

        <p><strong>Atualizado em:</strong> {{ $resultado->updated_at }}</p>
    @endforeach
@endsection
