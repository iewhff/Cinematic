@extends('layout.base')

@section('title', $title)

@section('content')

    <div>Bilhetes no carrinho de compras:

        @foreach ($filmes as $item)
            <div class="container">{{ $item['filme']->titulo }}</div>
        @endforeach

    </div>

@endsection
