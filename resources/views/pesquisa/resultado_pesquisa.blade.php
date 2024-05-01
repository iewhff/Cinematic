@extends('layout.base')
@extends('css.paginate')

@section('content')
    <a href="{{ URL::previous() }}" class="btn btn-primary">Voltar</a>
    {{ $resultados->links() }}

    @foreach ($resultados as $resultado)
        <div class="row">
            <div class="col-md-8">
                <p><strong>Título:</strong> {{ $resultado->titulo }}</p>

                <p><strong>Gênero:</strong> {{ $resultado->genero_code }}</p>

                <p><strong>Ano:</strong> {{ $resultado->ano }}</p>

                <p> <img src="{{ asset('caminho/para/cartazes/' . $resultado->cartaz_url) }}" alt="{{ $resultado->titulo }}"
                        width="200"></p>

                <p><strong>Sumário:</strong> {{ $resultado->sumario }}</p>

                <p><strong>Trailer:</strong> <a href="{{ $resultado->trailer_url }}" target="_blank">Assistir ao Trailer</a>
                </p>

                <p><strong>Criado em:</strong> {{ $resultado->created_at }}</p>

                <p><strong>Atualizado em:</strong> {{ $resultado->updated_at }}</p>
            </div>
            <div class="col-md-4 text-center">

                <form class="form-inline my-2 my-lg-0" action="{{ route('comprarBilhete') }}" method="GET">
                    @csrf
                    <input type="hidden" name="id" value={{ $resultado->id }}>
                    <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Comprar Bilhete</button>
                </form>
            </div>
        </div>
        <hr>
    @endforeach
    {{ $resultados->links() }}
@endsection
