@extends('layout.base')

@section('title', $title)

@section('content')

    @php
        $i = -1;
    @endphp
    <div>
        <a href="/filmes" class="btn btn-primary">Voltar</a>
        <div class="d-flex justify-content-between align-items-center">
            <div>
            @if (count($filmes) > 0)
            <h4>Bilhetes no carrinho de compras:</h4></div>
            <div>
                <form action="{{ route('removerTudoCarrinho') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn btn-danger">Remover Tudo!</button>
                </form>
            </div>
            @endif
            @if (count($filmes) == 0)
            <h4>Sem bilhetes no carrinho de compras!</h4></div>
            @endif


            </div>


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
    @if (count($filmes) > 0)
        <p><strong>Preço:</strong> {{ $precoTotal }} €</p>

        <form class="mt-4" action="comprarBilhete" method="GET">
            @csrf
            <input type="hidden" name="filmesID" value="@php
            foreach ($filmes as $key => $value) {
                echo $value['filme']->id . ',';
            }
        @endphp">
            <button type="submit" class="btn btn-primary">Finalizar Compra</button>
        </form>
    @endif

@endsection
