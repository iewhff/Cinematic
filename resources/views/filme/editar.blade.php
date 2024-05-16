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

    if (!isset($editar)) {
        $editar = null;
    }
    @endphp
    <br>
    <a href="/editarFilmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="row col-auto d-flex ">
                    <div class="col-md-4 d-flex ">
                        <form class="my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                            @csrf
                            <input type="hidden" name="editar" value="titulo">
                            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                        </form>
                    </div>
                    <div class="col-md-1 d-flex ">
                    </div>
                    <div class="col-md-7 d-flex ">
                        <p class="mb-0 ml-2"><strong>Título:</strong>
                            @if ($editar != 'titulo')
                                {{ $filme->titulo }}
                            @else
                        </p>
                        <form class="my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                            @csrf
                            <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="inputText">
                            <input type="hidden"  name="editando" value="titulo">
                            <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="genero">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Gênero:</strong>
                        @if ($editar != 'genero')
                        {{ $filme->genero_code }}</p>
                        @endif
                        @if ($editar == 'genero')
                            <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <select class="form-control mr-2" name="inputText">
                                    <option value="ACTION">Ação</option>
                                    <option value="ADVENTURE">Aventura</option>
                                    <option value="ANIMATION">Animação</option>
                                    <option value="BIBLOGRAPHY">Bibliografica</option>
                                    <option value="COMEDY">Comédia</option>
                                    <option value="COMEDY-ACTION">Comédia Ação</option>
                                    <option value="COMEDY-ROMANCE">Comédia Romantica</option>
                                    <option value="CRIME">Crime</option>
                                    <option value="CULT">Filme de culto</option>
                                    <option value="DRAMA">Drama</option>
                                    <option value="FAMILY">Família</option>
                                    <option value="FANTASY">Fantasia</option>
                                    <option value="HISTORY">Histórico</option>
                                    <option value="HORROR">Terror</option>
                                    <option value="MISTERY">Mistério</option>
                                    <option value="MUSICAL">ROMANCE</option>
                                    <option value="SCI-FI">Ficção científica</option>
                                    <option value="SILENT">Filme silencioso</option>
                                    <option value="SUPERHERO">Super herois</option>
                                    <option value="THRILLER">Suspense</option>
                                    <option value="WAR">Super Guerra</option>
                                    <option value="WESTERN">Western</option>
                                </select>
                                <input type="hidden"  name="editando" value="genero">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                            </form>

                        @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex">
                    <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="ano">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Ano:</strong>
                        @if ($editar != 'ano')
                        {{ $filme->ano }}</p>
                        @endif
                        @if ($editar == 'ano')
                            <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden"  name="editando" value="ano">
                                <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="inputText">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                            </form>
                        @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="sumario">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Sumário:</strong>
                        @if ($editar != 'sumario')
                        {{ $filme->sumario }}</p>
                        @endif
                        @if ($editar == 'sumario')
                            <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden"  name="editando" value="sumario">
                                <input type="text" class="form-control mr-2" placeholder="{{ $filme->sumario }}" name="inputText">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                            </form>
                        @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="trailer_url">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Trailer:</strong>
                        @if ($editar != 'trailer_url')
                        <a href="{{ $filme->trailer_url }}" target="_blank">Assistir ao Trailer</a></p>
                        @endif
                        @if ($editar == 'trailer_url')
                    </a></p>
                            <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden"  name="editando" value="url">
                                <input type="text" class="form-control mr-2" placeholder="Insira o url" name="inputText">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                            </form>
                        @endif
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="cartaz_url">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>

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
                        @if ($editar == 'cartaz_url')
                    </a></p>
                    <form action="{{ route('editar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="image">Escolha uma imagem</label>
                            <input type="file" name="image" class="form-control" id="image">
                            @error('image')
                                <div class="alert alert-danger mt-2">{{ $message }}</div>
                            @enderror
                        </div>
                        <input type="hidden" name="id" value="{{ $filme->id }}">
                        <button type="submit" class="btn btn-primary mt-3">Upload</button>
                    </form>

                        @endif
                </div>
            </div>
            <p><strong>Criado em:</strong> {{ $filme->created_at }}</p>
            <p><strong>Atualizado em:</strong> {{ $filme->updated_at }}</p>
        </div>
    </div>





@endsection
