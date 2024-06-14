@extends('layout.base')

@section('content')


@if ($errors->any())


        <div>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('processar.form') }}" method="POST">


        @csrf
        <label for="bilhete_id">ID do Bilhete:</label>
        <input type="text" id="bilhete_id" name="bilhete_id">
        <input value="{{$sessao_id}}" type="hidden" id="sessao_id" name="sessao_id">
        <button type="submit">Enviar</button>
    </form>


@endsection
