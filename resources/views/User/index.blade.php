@extends('layout.base')

@section('main')



<div class="container">

    <form action="{{ route('searchUser')}}" method="POST">
     @csrf
        <div class="input-group">
            <input type="text" class="form-control"  name="pesquisa"
                placeholder="Nome ou email"> <span class="input-group-btn">
                <button type="submit" class="btn btn-default">
                    <span class="glyphicon glyphicon-search"></span>
                </button>
            </span>
        </div>
    </form>

    <h1>User List</h1>
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
                <td>{{ $user->name }}</td>

                <td>{{ $user->email }}</td>

                @if($user->tipo == 'A')
                <td>Administrador</td>
                @elseif($user->tipo == 'F')
                <td>Funcionario</td>
                @else
                <td>Cliente</td>
                @endif

                @if($user->bloqueado == 1)
                <td>Sim</td>
                @else
                <td>Não</td>
                @endif

                <td>
                    @if($user->tipo == 'C')
                <td class="button-icon-col"><a href="{{ route('user.show', ['user' => $user]) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a></td>
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('user.softDelete', ['id' => $user->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
                @else
                <td class="button-icon-col"><a href="{{ route('user.show', ['user' => $user]) }}" class="btn btn-secondary"><i class="fas fa-eye"></i></a></td>
                <td class="button-icon-col"><a href="{{ route('user.edit', ['user' => $user]) }}" class="btn btn-dark"><i class="fas fa-edit"></i></a></td>
                @if($user!= Auth::user())
                <td class="button-icon-col">
                    <form method="POST" action="{{ route('user.index', ['user' => $user]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" name="delete" class="btn btn-danger">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </td>
                </td>
                @endif
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection