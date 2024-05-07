@extends('layout.base')


@section('title', $title)
@section('content')
    <div>
        <h1> {{ $h1 }}</h1>
        <p>
            {{ $msgErro }}
        </p>
        <!-- Adicione qualquer conteúdo adicional, como botões ou links -->
    </div>
@endsection
