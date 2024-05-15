@extends('layout.base')
@section('title', $title)

@section('content')
    <br>
    <div class="container">
        <div class="row justify-content-between">
            <div class="col-auto">
                <a href="/filmes" class="btn btn-primary">Voltar</a>
            </div>
            <div class="col-auto">
                <a href="/adicionarFilme" class="btn btn-primary">Adicionar</a>
            </div>
        </div>
    </div>

    {{ $filmes->links() }}

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
    <table>
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
            <th>Eliminar</th>
        </tr>
        @foreach ($filmes as $um_filme)
            <tr class="filme-row">
                <td>{{ $um_filme->titulo }}</td>
                <td>{{ $um_filme->genero_code }}</td>
                <td>{{ $um_filme->ano }}</td>
                <td class="cartaz-cell">
                    {{-- Verifica se existe um cartaz_url --}}
                    @if ($um_filme->cartaz_url)
                        <img src="{{ asset('public/cartazes/' . $um_filme->cartaz_url) }}" height="30px" width="30px" />
                    @endif

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

                    <form class="form-inline my-2 my-lg-0" action="{{ route('editar') }}" method="GET">
                        @csrf
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id"
                            value={{ $um_filme->id }}>Editar
                        </button>
                    </form>

                </td>
                <td>

                    <form class="form-inline my-2 my-lg-0" action="{{ route('eliminarFilme') }}" method="GET">
                        @csrf
                        <button class="btn btn-danger my-2 my-sm-0" type="submit" name="id"
                            value={{ $um_filme->id }}>Eliminar
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>
    {{ $filmes->links() }}
@endsection
