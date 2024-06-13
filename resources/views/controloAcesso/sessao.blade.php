@extends('layout.base')

@section('title', $title)

@section('content')


<h1>Selecione uma sessao</h1>7 

<form action="{{ route('escolherLugar') }}" method="GET">
    @csrf
    <div class="row mb-3">
        <div class="col-md-6">
            <label for="sessao" class="form-label">Sessão:</label>
            <select id="sessao" name="sessao_id" class="form-select">
                @foreach ($sessoes as $sessao)

                <option value="{{ $sessao->id }}">
                    Sala: {{ $sessao->sala_nome }} - Data: {{ $sessao->data}} - Horário: {{ $sessao->horario_inicio }}
                </option>
                @endforeach
                <input type="hidden" name="filmeId" value="{{ $filmeId }}">
                <input type="hidden" name="sessaoId" value="{{ $sessao->id }}">
            </select>
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary mt-4">Continuar</button>
        </div>
    </div>
</form>








@endsection
