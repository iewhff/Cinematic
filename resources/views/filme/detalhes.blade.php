@extends('layout.base')

@section('content')
    <br>
    <a href="/filmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-8">
            <p><strong>Título:</strong> {{ $filme->titulo }}</p>
            <p><strong>Gênero:</strong> {{ $filme->genero_code }}</p>
            <p><strong>Ano:</strong> {{ $filme->ano }}</p>
            <p> <img src="{{ asset('caminho/para/cartazes/' . $filme->cartaz_url) }}" alt="{{ $filme->titulo }}"
                    width="200"></p>
            <p><strong>Sumário:</strong> {{ $filme->sumario }}</p>
            <p><strong>Trailer:</strong> <a href="{{ $filme->trailer_url }}" target="_blank">Assistir ao
                    Trailer</a></p>
            <p><strong>Criado em:</strong> {{ $filme->created_at }}</p>
            <p><strong>Atualizado em:</strong> {{ $filme->updated_at }}</p>
        </div>
        <div class="col-md-4 text-center">
            <form class="form-inline my-2 my-lg-0" action="{{ route('comprarBilhete') }}" method="GET">
                @csrf
                <input type="hidden" name="id" value="{{ $filme->id }}">
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Comprar Bilhete</button>
            </form>
        </div>
    </div>
@endsection
