@extends('layout.base')

@section('content')

<div class="row">
    <div class="col-md-8">
    @dump($errors)
        <form id="updateUser" method="POST" action="{{ route('user.update', ['user'=>$user])}}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <img src="{{ asset('storage/fotos/'.$user->foto_url) }}" alt="Profile Picture" class="img-fluid rounded-circle">

            <div class="form-group">
                <label for="inputNome">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $user->id }}">

            </div>

            <div class="form-group">
                <label for="inputNome">Nome</label>
                <input type="text" name="name" class="form-control" value="{{ $user->name }}">

            </div>
            <div class="form-group">
                <label for="inputNome">Email</label>
                <input type="text" name="email" class="form-control" value="{{ $user->email }}">

            </div>
            <div class="form-group">
                <label for="inputNome">Tipo</label>

                <select name="tipo" id="tipo_user" class="form-control">
                    <option value="" disabled selected>Tipo de Utilizador</option>
                    @foreach ($tipoUser as $tipoUtilizador => $label)
                        <option value="{{ $tipoUtilizador }}"
                            {{ old('tipo', $user->tipo) == $tipoUtilizador ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>

            <p><strong>Bloqueado?
                <span style="color: {{ $user->bloqueado ? 'red' : 'green' }}">
                    {{ $user->bloqueado ? 'Sim' : 'Não' }}
                </span></strong>
            </p>

            <button type="submit" class="btn btn-primary" form="updateUser">Guardar</button>
            <a href="/users" class="btn btn-primary">Voltar</a>
        </form>
    </div>
</div>

@endsection
