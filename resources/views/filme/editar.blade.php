@extends('layout.base')
@section('title', $title)

@section('content')
    @php
    if (!isset($editar)) {
        $editar = null;
    }
    @endphp
    <br>
    <a href="/editarFilmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <form class="my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <input type="hidden" name="editar" value="titulo">
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Editar</button>
                    </form>
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
                    <p> <img src="{{ asset('caminho/para/cartazes/' . $filme->cartaz_url) }}" alt="{{ $filme->titulo }}"
                        width="200"></p>
                        @if ($editar == 'cartaz_url')
                    </a></p>
                            <form class=" my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                                @csrf
                                <input type="hidden"  name="editando" value="cartaz_url">
                                <input type="text" class="form-control mr-2" placeholder="Insira o url" name="inputText">
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id" value="{{ $filme->id }}">Gravar</button>
                            </form>
                        @endif
                </div>
            </div>
            <p><strong>Criado em:</strong> {{ $filme->created_at }}</p>
            <p><strong>Atualizado em:</strong> {{ $filme->updated_at }}</p>
        </div>
    </div>





@endsection
