@extends('layout.base')

@section('content')

    @if ($bilhetes->isEmpty())
        <p>Nenhum bilhete encontrado para o ID da sessão fornecido.</p>
    @elseif($idSessao != $sessaoBil)   
    <p>O bilhete não pertence a esta sessão</p>
    @else

    <div>
    <div class="col-md-4 ">
        <ul>
            @foreach ($bilhetes as $bilhete)
                <li>ID do Bilhete: {{ $bilhete->id }}</li>
                <li>ID da Sessão: {{ $bilhete->sessao_id }}</li>
                <li>Estado do Bilhete: {{ $bilhete->estado }}</li>
            @endforeach
        </ul> 
    </div>

   
      <div class="col-md-8">
         @if ($bilhete->estado == "não usado")
            <ul>
                <li>
                <form action="{{ route('bilhete.show', ['id' => $bilhete->id, 'idSessao' => $bilhete->sessao_id] ) }}" method="POST">
                    @csrf

                    <button type="submit">Validar Bilhete</button>
                    </form>
                </li>
            </ul>
            @endif
        </div>

    

    </div>
    @endif

@endsection
