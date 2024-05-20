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

    {{ $filmes->links() }}

    {{-- Dropdown de Gêneros, podia tar melhor de aspecto --}}
    <div class="container">
        <div class="row justify-content-end">
            <div class="col-md-6">
                <form class="d-flex flex-row align-items-center" action="{{ route('filmes') }}" method="GET">
                    <button type="submit" class="btn btn-primary mr-2">Filtrar</button>
                    <div class="form-group mb-0">
                        <select class="form-control" name="code">
                            <option value="">Selecione um gênero</option>
                            @foreach ($opcoes as $opcao)
                                <option value="{{ $opcao->code }}" {{ $opcao->code == request('code') ? 'selected' : '' }}>
                                    {{ $opcao->nome }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="col-md-6 text-end">
                <form class="form-inline my-2 my-lg-0" action="{{ route('filmes') }}" method="GET">
                    @csrf
                    <button class="btn my-2 my-sm-0" type="submit">
                        Todos os Filmes
                    </button>
                </form>




            </div>
        </div>
    </div>




    <div class="container">
    {{-- Tabela de filmes --}}
    <table id="table">
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
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
        } elseif(file_exists($imagePathWithYear) && is_readable($imagePathModified)){
            $finalImagePath = $imagePathWithYear;
        }else {
            $finalImagePath = null;
        }
        @endphp

                <tr style="{{ $finalImagePath ? 'background-image: url(' . asset($finalImagePath) . '); background-size: cover; background-position: center center;' : '' }}">
                <td>{{ $um_filme->titulo }}</td>
                <td>{{ $um_filme->genero_code }}</td>
                <td>{{ $um_filme->ano }}</td>
                <td class="cartaz-cell">


                    {{-- @if ($finalImagePath)
                        <img src="{{ asset($finalImagePath) }}" width="200px" />
                    @endif --}}

                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('detalhes') }}" method="GET">
                        @csrf
                        <button class="btn my-2 my-sm-0" type="submit" name="id" value={{ $um_filme->id }}>
                            Detalhes
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>

    {{-- Centraliza novamente os links de paginação --}}

    {{ $filmes->links() }}

</div>
@endsection
