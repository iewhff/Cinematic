@extends('layout.base')

@section('title', $title)

@section('content')
    @php
        if (!isset($editar)) {
            $editar = null;
        }
    @endphp
    <br>
    <a href="/filmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="titulo">
                        <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Título:</strong>
                        @if ($editar != 'titulo')
                            {{ $filme->titulo ?? 'Título não disponível' }}
                        @else
                            <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                                <input type="hidden" name="editando" value="titulo">
                                <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="inputText" value="{{ old('inputText', $filme->titulo ?? '') }}">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="genero">
                        <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Gênero:</strong>
                        @if ($editar != 'genero')
                            {{ $filme->genero_code ?? 'Gênero não disponível' }}
                        @else
                            <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                                <input type="hidden" name="editando" value="genero">
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
                                    <option value="MUSICAL">Musical</option>
                                    <option value="ROMANCE">Romance</option>
                                    <option value="SCI-FI">Ficção científica</option>
                                    <option value="SILENT">Filme silencioso</option>
                                    <option value="SUPERHERO">Super heróis</option>
                                    <option value="THRILLER">Suspense</option>
                                    <option value="WAR">Guerra</option>
                                    <option value="WESTERN">Western</option>
                                </select>
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-auto d-flex">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="ano">
                        <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Ano:</strong>
                        @if ($editar != 'ano')
                            {{ $filme->ano ?? 'Ano não disponível' }}
                        @else
                            <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                                <input type="hidden" name="editando" value="ano">
                                <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="inputText" value="{{ old('inputText', $filme->ano ?? '') }}">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="sumario">
                        <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Sumário:</strong>
                        @if ($editar != 'sumario')
                            {{ $filme->sumario ?? 'Sumário não disponível' }}
                        @else
                            <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                                <input type="hidden" name="editando" value="sumario">
                                <input type="text" class="form-control mr-2" placeholder="{{ $filme->sumario ?? 'Insira o sumário' }}" name="inputText">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>
                        @endif
                    </p>
                </div>
            </div>

            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="trailer_url">
                        <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Editar</button>
                    </form>
                    <p class="mb-0 ml-2"><strong>Trailer:</strong>
                        @if ($editar != 'trailer_url')
                            <a href="{{ $filme->trailer_url ?? '#' }}" target="_blank">Assistir ao Trailer</a>
                        @else
                            <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden" name="id" value="{{ $filme->id ?? '' }}">
                                <input type="hidden" name="editando" value="url">
                                <input type="text" class="form-control mr-2" placeholder="Insira o URL" name="inputText" value="{{ old('inputText', $filme->trailer_url ?? '') }}">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>
                        @endif
                    </p>
                </div>
            </div>

            <p><strong>Criado em:</strong> {{ $filme->created_at ?? 'Data não disponível' }}</p>
            <p><strong>Atualizado em:</strong> {{ $filme->updated_at ?? 'Data não disponível' }}</p>
        </div>
    </div>
@endsection
