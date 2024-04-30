@extends('layout.base')

@section('content')
    @foreach ($resultados as $resultado)
        <form action="/comprarBilhete" method="post">
            @csrf
            <div>
                <label for="nome">Nome do filme:</label>
                <span>{{ $resultado->titulo }}</span>
            </div>
            <div>
                <label for="nome">Nome:</label>
                <span>{{ $resultado->titulo }}</span>
            </div>
            <input type="submit">
        </form>
    @endforeach
@endsection
