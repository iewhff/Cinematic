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
        $string = preg_replace('/\s/', '', $string, 1); // Remove o primeiro espaço
        return str_replace(' ', '_', $string); // Substitui os espaços restantes por underscores
    }


@endphp
    {{-- Centraliza os links de paginação --}}
<div class="container mt-5 text-center">
    {{-- Tabela de filmes --}}
    <h2>Com base nas suas preferencias</h2>
    @isset($filmes)
    @if(count($filmes) > 0)
    <table class="table-filmes ">
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
            <th>Comprar Bilhete</th>
        </tr>

        @foreach ($filmes as $um_filme)

        @php


        $originalString = $um_filme->titulo.'.jpg';
        $processedString = processString($originalString);
        $underscoredString = replaceSpacesWithUnderscore($originalString);
        $modifiedString = removeFirstSpaceAndReplaceOthers($originalString);

        // Caminhos de imagem para verificar
        $imagePath = public_path('imgs/cartazes/' . $processedString);
        $imagePathUnderscore = public_path('imgs/cartazes/' . $underscoredString);
        $imagePathModified = public_path('imgs/cartazes/' . $modifiedString);
        $imagePathWithYear =  public_path('imgs/cartazes/' . $um_filme->titulo.'_'.$um_filme->ano.'.jpg');

        // Verifica se o arquivo existe e é legível
        if (file_exists($imagePath) && is_readable($imagePath)) {
            $finalImagePath = 'imgs/cartazes/' . $processedString;
        } elseif (file_exists($imagePathUnderscore) && is_readable($imagePathUnderscore)) {
            $finalImagePath = 'imgs/cartazes/' . $underscoredString;
        } elseif (file_exists($imagePathModified) && is_readable($imagePathModified)) {
            $finalImagePath = 'imgs/cartazes/' . $modifiedString;
        }elseif(file_exists($imagePathWithYear) && is_readable($imagePathModified)){
            $finalImagePath = 'imgs/cartazes/' . $um_filme->titulo.'_'.$um_filme->ano.'.jpg';
        }else {
            $finalImagePath = null;
        }
        @endphp

<tr style="{{ $finalImagePath ? 'background-image: url(' . asset($finalImagePath) . '); background-size: cover; background-position: center center;' : '' }}">
                <td>{{ $um_filme->titulo }}</td>
                <td>{{ $um_filme->genero_code }}</td>
                <td>{{ $um_filme->ano }}</td>
                <td class="cartaz-cell">
                    {{-- Verifica se existe um cartaz_url --}}


                    {{-- @if ($finalImagePath)
                        <img src="{{ asset($finalImagePath) }}" width="200px" />
                    @endif --}}

                    {{-- Verifica se há uma imagem correspondente
                    @foreach ($imagens as $uma_imagem)
                        @if ($um_filme->cartaz_url == $uma_imagem['nome'])
                            <img src="{{ asset('data:image/jpeg;base64,' . base64_encode($uma_imagem['imagem'])) }}"
                                alt="{{ $uma_imagem['nome'] }}">
                        @endif
                    @endforeach
                     --}}
                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('detalhes') }}" method="GET">
                        @csrf
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id"
                            value={{ $um_filme->id }}>Detalhes
                        </button>
                    </form>

                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('carrinhoCompras') }}" method="GET">
                        @csrf
                        <input type="hidden" name="id" value="{{ $um_filme->id }}">
                        <button class="botao btn btn-outline-dark my-2 my-sm-0" type="submit">Comprar</button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
    @else
    <p>Nenhum filme disponível.</p>
@endif
@else
<p>Variável de filmes não está definida.</p>
@endisset


</div>


<div class="container mt-5 text-center">
    {{-- Tabela de filmes --}}
    <h2>Top filmes do Cinematic</h2>
    @isset($topFilmes)
    @if(count($topFilmes) > 0)
    <table class="table-filmes">
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
            <th>Comprar Bilhete</th>
        </tr>
        @foreach ($topFilmes as $um_filme)
        @php


        $originalString = $um_filme->titulo.'.jpg';
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

<tr style="{{ $finalImagePath ? 'background-image: url(' . asset($finalImagePath) . '); background-size: cover; background-position: center center;' : '' }}">
                <td>{{ $um_filme->titulo }}</td>
                <td>{{ $um_filme->genero_code }}</td>
                <td>{{ $um_filme->ano }}</td>
                <td class="cartaz-cell">
                    {{-- Verifica se existe um cartaz_url --}}

{{--
                    @if ($finalImagePath)
                        <img src="{{ asset($finalImagePath) }}" width="200px" />
                    @endif --}}

                    {{-- Verifica se há uma imagem correspondente
                    @foreach ($imagens as $uma_imagem)
                        @if ($um_filme->cartaz_url == $uma_imagem['nome'])
                            <img src="{{ asset('data:image/jpeg;base64,' . base64_encode($uma_imagem['imagem'])) }}"
                                alt="{{ $uma_imagem['nome'] }}">
                        @endif
                    @endforeach
                     --}}
                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('detalhes') }}" method="GET">
                        @csrf
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id"
                            value={{ $um_filme->id }}>Detalhes
                        </button>
                    </form>

                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('carrinhoCompras') }}" method="GET">
                        @csrf
                        <input type="hidden" name="id" value="{{ $um_filme->id }}">
                        <button class="botao btn btn-outline-dark my-2 my-sm-0" type="submit">Comprar</button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
        @else
    <p>Nenhum filme disponível.</p>
@endif
@else
<p>Variável de filmes não está definida.</p>
@endisset


</div>
@endsection
