@extends('layout.base')
@section('title', $title)

@section('content')
    <br>
    <a href="/editarFilmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-12">
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <p class="mb-0 ml-2"><strong>Título:</strong>
                    </p>
                            <form class="form-inline my-2 my-lg-0" action="{{ route('adicionar') }}" method="POST">
                                @csrf
                                <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="titulo">
                                @error('titulo')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <p class="mb-0 ml-2"><strong>Gênero:</strong></p>
                                <select class="form-control mr-2" name="genero_code">
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
                                @error('genero_code')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex">
                    <p class="mb-0 ml-2"><strong>Ano:</strong></p>
                                <input type="text" class="form-control mr-2" placeholder="Digite algo aqui" name="ano">
                                @error('ano')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <p class="mb-0 ml-2"><strong>Sumário:</strong></p>
                                <input type="text" class="form-control mr-2" placeholder="Sumario" name="sumario">
                                @error('sumario')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror

                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <p class="mb-0 ml-2"><strong>Trailer:</strong></p>
                                <input type="text" class="form-control mr-2" placeholder="Insira o url" name="trailer_url">
                                @error('trailer_url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                </div>
            </div>
            <div class="row mb-2">
                <div class="col-auto d-flex ">
                    <p class="mb-0 ml-2"><strong>Cartaz:</strong></p>

                                <input type="text" class="form-control mr-2" placeholder="Insira o url" name="cartaz_url">
                                @error('cartaz_url')
                                <span class="text-danger">{{ $message }}</span>
                                @enderror
                                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">Gravar</button>
                            </form>

                </div>
            </div>
        </div>
    </div>





@endsection
