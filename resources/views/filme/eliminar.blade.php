@extends('layout.base')
@section('title', $title)

@section('content')
    <br>
    <a href="/editarFilmes" class="btn btn-primary">Voltar</a>
<div class="container mt-5 m-20">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h3 class="mb-4">Deseja realmente eliminar o filme <strong>{{ $filme->titulo }}</strong>?</h3>
            <form action="{{ route('eliminar') }}" method="POST">
                @csrf
                <input type="hidden" name="id" value="{{ $filme->id }}">
                <button type="submit" class="btn btn-danger m-20">Eliminar</button>
                <a href="{{ route('editarFilmes') }}" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>
@endsection





