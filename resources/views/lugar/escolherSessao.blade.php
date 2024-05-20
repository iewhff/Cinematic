@extends('layout.base')

@section('title', $title)

@section('content')


@foreach ($sessoes as $sessao )
    <div class="row mb-3">
        <div class="col-md-6">
            <p class="title">{{ $sessao->filme->titulo }}</p>
        </div>
        <div class="col-md-3">

        </div>
    </div>
    <hr>
@endforeach








@endsection
