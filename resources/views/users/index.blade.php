@extends('layout.base')
{{--@extends('css.tabela')--}}


@section('content')
    <h1>Lista de Utilizadores</h1>

    <a href="{{ route('users.create') }}" class="btn btn-secondary">Criar Novo Utilizador</a>

    <form method="GET" action="{{ route('users') }}">
        <div class="form-group">
            <label for="tipo">Filtrar por Tipo de Utilizador</label>
            <select name="tipo" id="tipo" class="form-control">
                <option value="">Todos</option>
                @foreach ($tipoUser as $tipoUtilizador => $label)
                    <option value="{{ $tipoUtilizador }}" {{ request('tipo') == $tipoUtilizador ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Filtrar</button>
    </form>


    <table class="table table-striped">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Email</th>
                <th>Tipo</th>
                <th>Bloqueado?</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    @if ($user->tipo != 'C')
                    <td>{{ $user->name }}</td>
                    @else
                    <td>********</td>
                    @endif

                    <td>{{ $user->email }}</td>

                    @if ($user->tipo == 'A')
                        <td>Administrador</td>
                    @elseif($user->tipo == 'F')
                        <td>Funcionario</td>
                    @else
                        <td>Cliente</td>
                    @endif

                    @if ($user->bloqueado == 1)
                        <td style="color: red">Sim</td>
                    @else
                        <td style="color: green">Não</td>
                    @endif

                    <td>
                        @if ($user->tipo == 'C')
                            @if ($user->bloqueado == 0)
                                <form method="POST" action="{{ route('user.block', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-secondary">Bloquear</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('user.unblock', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-secondary">Desbloquear</button>
                                </form>
                            @endif
                    <td class="button-icon-col">
                        <form method="POST" action="{{ route('user.softDelete', ['id' => $user->id]) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit" name="delete" class="btn btn-danger">
                                <i class="fas fa-trash"></i>Apagar
                            </button>
                        </form>
                    </td>
                @else
                    <td class="button-icon-col"><a href="{{ route('user.show', ['user' => $user]) }}"
                            class="btn btn-secondary"><i class="fas fa-eye"></i>Visualizar</a></td>
                    <td class="button-icon-col"><a href="{{ route('user.edit', ['user' => $user]) }}"
                            class="btn btn-dark"><i class="fas fa-edit"></i>Editar</a></td>
                    @if ($user != Auth::user())
                    <td>
                        @if ($user->bloqueado == 0)
                                <form method="POST" action="{{ route('user.block', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-secondary">Bloquear</button>
                                </form>
                        @else
                                <form method="POST" action="{{ route('user.unblock', ['user' => $user->id]) }}">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit" class="btn btn-secondary">Desbloquear</button>
                                </form>
                        @endif
                    </td>
                    @endif
                    @if ($user != Auth::user())
                        <td class="button-icon-col">
                            <form method="POST" action="{{ route('user.softDelete', ['id' => $user->id]) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" name="delete" class="btn btn-danger">
                                    <i class="fas fa-trash"></i>Apagar
                                </button>
                            </form>
                        </td>
                    @endif
            @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    {{ $users->links() }}
@endsection
