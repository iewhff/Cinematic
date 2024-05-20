@extends('layout.base')
@section('title', $title)
@section('content')


@php

    // Função para remover espaços
    function processString($string) {
        return str_replace(' ', '', $string);
    }

    // Função para substituir espaços por underscores
    function replaceSpacesWithUnderscore($string) {
        return str_replace(' ', '_', $string);
    }

    // Função para remover o primeiro espaço e substituir os seguintes por underscores
    function removeFirstSpaceAndReplaceOthers($string) {
        $string = preg_replace('/\s/', '_', $string, 1); // Remove o primeiro espaço
        return str_replace(' ', '_', $string); // Substitui os espaços restantes por underscores
    }

@endphp
    <br>
    <a href="/filmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-8">
            <p><strong>Título:</strong> {{ $filme->titulo }}</p>
            <p><strong>Gênero:</strong> {{ $filme->genero_code }}</p>
            <p><strong>Ano:</strong> {{ $filme->ano }}</p>
            @php


            $originalString = $filme->titulo.'.jpg';
            $processedString = processString($originalString);
            $underscoredString = replaceSpacesWithUnderscore($originalString);
            $modifiedString = removeFirstSpaceAndReplaceOthers($originalString);

            // Caminhos de imagem para verificar
            $imagePath = public_path('imgs/cartazes/' . $processedString);
            $imagePathUnderscore = public_path('imgs/cartazes/' . $underscoredString);
            $imagePathModified = public_path('imgs/cartazes/' . $modifiedString);

            // Verifica se o arquivo existe e é legível
            if (file_exists($imagePath) && is_readable($imagePath)) {
                $finalImagePath = 'imgs/cartazes/' . $processedString;
            } elseif (file_exists($imagePathUnderscore) && is_readable($imagePathUnderscore)) {
                $finalImagePath = 'imgs/cartazes/' . $underscoredString;
            } elseif (file_exists($imagePathModified) && is_readable($imagePathModified)) {
                $finalImagePath = 'imgs/cartazes/' . $modifiedString;
            } else {
                $finalImagePath = null;
            }
            @endphp



                        @if ($finalImagePath)
                            <img src="{{ asset($finalImagePath) }}" width="200px" />
                        @endif
            <p><strong>Sumário:</strong> {{ $filme->sumario }}</p>
            <p><strong>Trailer:</strong> <a href="{{ $filme->trailer_url }}" target="_blank">Assistir ao Trailer</a></p>
            <div class="video-container">
                <iframe src="{{ $filme->trailer_url }}" frameborder="0" allowfullscreen></iframe>
            </div>
            <p><strong>Criado em:</strong> {{ $filme->created_at }}</p>
            <p><strong>Atualizado em:</strong> {{ $filme->updated_at }}</p>
        </div>
        <div class="col-md-4 text-end mt-2"> <!-- Adicione a classe mt-2 aqui -->
            @if ($existeSessao)
                <div class="col-md-12 text-center">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('carrinhoCompras') }}" method="GET">
                        @csrf
                        <input type="hidden" name="id" value="{{ $filme->id }}">
                        <button class="botao btn btn-outline-dark my-2 my-sm-0" type="submit">Comprar Bilhete</button>
                    </form>
                </div>
                <div class="col-md-12 text-center">
                    <form action="{{ route('carrinhoCompras') }}" method="POST">
                        @csrf
                        <input type="hidden" name="id" value="{{ $filme->id }}">
                        <button type="submit" class="botao btn btn-outline-dark my-2 my-sm-0">Adicionar ao Carrinho de Compras</button>
                    </form>

                </div>
            @endif
        </div>
    </div>
@endsection
