@extends('layout.base')
@extends('css.tabela')
@extends('css.paginate')

@section('content')
    {{-- Centraliza os links de paginação --}}

    {{ $filmes->links() }}

    {{-- Dropdown de Gêneros, podia tar melhor de aspecto --}}
    <div class="container">
        <div class="row justify-content-end mt-5 ">
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
                <a class="botao" href="/filmes">Todos os Filmes</a>
            </div>
        </div>
    </div>





    {{-- Tabela de filmes --}}
    <table>
        <tr>
            <th>Titulo</th>
            <th>Género</th>
            <th>Ano</th>
            <th>Cartaz</th>
            <th>Detalhes</th>
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

                    <form class="form-inline my-2 my-lg-0" action="{{ route('detalhes') }}" method="GET">
                        @csrf
                        <button class="btn btn-outline-dark my-2 my-sm-0" type="submit" name="id"
                            value={{ $um_filme->id }}>Detalhes
                        </button>
                    </form>

                </td>
            </tr>
        @endforeach
    </table>

    {{-- Centraliza novamente os links de paginação --}}

    {{ $filmes->links() }}
@endsection