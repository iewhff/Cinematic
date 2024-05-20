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

@isset($filmes)
    @if($filmes->count()>0)

        <table id="table">
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
        </tr>
        @foreach ($filmes as $filme)
<<<<<<< HEAD


=======
        @php


            $originalString = $filme->titulo.'.jpg';
            $processedString = processString($originalString);
            $underscoredString = replaceSpacesWithUnderscore($originalString);
            $modifiedString = removeFirstSpaceAndReplaceOthers($originalString);

            // Caminhos de imagem para verificar
            $imagePath = public_path('imgs/cartazes/' . $processedString);
            $imagePathUnderscore = public_path('imgs/cartazes/' . $underscoredString);
            $imagePathModified = public_path('imgs/cartazes/' . $modifiedString);
            $imagePathWithYear =  public_path('imgs/cartazes/' . $filme->titulo.'_'.$filme->ano.'.jpg');

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
                <tr style="{{ $finalImagePath ? 'background-image: url(' . asset($finalImagePath) . '); background-size: cover; background-position: center center;' : '' }}"></tr>
>>>>>>> 9162c96ca0e9ac85344c77263c0754c3634af382
                <td>{{ $filme->titulo }}</td>
                <td>{{ $filme->genero_code }}</td>
                <td>{{ $filme->ano }}</td>
                <td class="cartaz-cell">

                


                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('detalhes') }}" method="GET">
                        @csrf
                        <button class="btn my-2 my-sm-0" type="submit" name="id" value={{ $filme->id }}>
                            Detalhes
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>

        {{ $filmes->links() }}
    @else
        <p>Não foram encontrados filmes com sessões abertas.</p>
    @endif
    @endisset
@endsection
