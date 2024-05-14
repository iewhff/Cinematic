@extends('layout.base')

@section('title', $title)

@section('content')

    @php
        $i = -1;
    @endphp
    <div>
        <h4>Bilhetes no carrinho de compras:</h4>
        @foreach ($filmes as $item)
        @php
        $lugaresId='';
        @endphp
            <div class="row mb-3">
                <div class="col-md-6">
                    <p class="title">{{ $item['filme']->titulo }}</p>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('removerCarrinho') }}" method="POST" class="d-inline">
                        @csrf
                        <input type="hidden" name="idRemover" value="{{ $item['filme']->id }}">
                        <button type="submit" class="btn btn-danger">Remover</button>
                    </form>
                </div>
            </div>
            <hr>
        @endforeach
    </div>
    <p><strong>Preço:</strong> {{ $precoTotal }}</p>
    <form class="mt-4" action="comprarBilhete" method="GET">
        @csrf
        <input type="text" name="filmesID" value="@php
        foreach ($filmes as $key => $value) {
            echo $value['filme']->id . ',';
        }
    @endphp">

        <button type="submit" class="btn btn-primary">Comprar</button>
    </form>
@endsection
