@extends('layout.base')
@section('title', $title)
@section('content')


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
