@extends('layout.base')

@section('title', 'Perfil do Usário')

@section('content')

{{--@include('User.shared.campos', ['readonlyData' => true])--}}

    <div class="row">
        <div class="col-md-8">
            <img src="{{ asset('storage/fotos/'.$user->foto_url) }}" alt="Profile Picture" class="img-fluid rounded-circle">
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Tipo:</strong>
                @switch($user->tipo)
                    @case('A')
                        Administrador
                        @break
                    @case('F')
                        Funcionário
                        @break
                    @case('C')
                        Cliente
                        @break
                    @default
                        Desconhecido
                @endswitch
            </p>

            <p><strong>Bloqueado?
                <span style="color: {{ $user->bloqueado ? 'red' : 'green' }}">
                    {{ $user->bloqueado ? 'Sim' : 'Não' }}
                </span></strong>
            </p>

        <a href="/users" class="btn btn-primary">Voltar</a>
    </div>
</div>
@endsection
