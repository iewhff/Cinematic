@extends('layout.base')
@section('title', $title)
@section('content')


    <br>
    <a href="/filmes" class="btn btn-primary">Voltar</a>
    <div class="row">
        <div class="col-md-8">
            <p><strong>Título:</strong> {{ $filme->titulo }}</p>
            <p><strong>Gênero:</strong> {{ $filme->genero_code }}</p>
            <p><strong>Ano:</strong> {{ $filme->ano }}</p>
          

            <br>

        </div>
        <div class="col-md-4 text-end mt-2"> <!-- Adicione a classe mt-2 aqui -->
            @if ($existeSessao)

    
                <div class="col-md-12 text-center">
                    
                    <br>
                    <h3>Sessões Dísponiveis</h3>

                        <table id="table">  
                            
                            <tr>
                                <th>Numero da sala</th>
                                <th>Nome da sala</th>
                                <th>Inicio</th>
                                <th>Data</th>
                                <th>Ocupação</th>
                            </tr>
                    
                            @foreach($sessoes as $sessao) 
                            @foreach($SalaExibicao as $salas)
                            
                                <tr>
                                    <td>{{$salas->id}}</td>
                                    <td>{{$salas->nome}}</td>
                                    <td>{{$sessao->horario_inicio}}</td>
                                    <td>{{$sessao->data}}</td>


                                    <td>{{$percentOcup}}%</td>
                                </tr>
                                
                            @endforeach
                            @endforeach
                            
                        </table>

                </div>

                <div class="btn-group-vertical btn-group " role="group"> 

                        <div class="text-center mr-1">
                            <form class="form-inline  " action="{{ route('carrinhoCompras') }}" method="GET">
                                @csrf
                                <input class="btn " type="hidden" name="id" value="{{ $filme->id }}">
                                <button class="botao btn btn-outline-dark " type="submit">Comprar bilhete</button>
                            </form>
                        </div>
                        
                        <div class=" text-center mr-1">
                            <form action="{{ route('carrinhoCompras') }}" method="POST">
                                @csrf
                                <input class="btn " type="hidden" name="id" value="{{ $filme->id }}">
                                <button type="submit" class="botao btn btn-outline-dark ">Adicionar ao carrinho</button>
                            </form>
                        </div>

                </div>

            @endif
        </div> 

    </div>
@endsection
