@extends('layout.base')
@extends('css.tabela')
@extends('css.paginate')

@section('content')
    <div class="container ">
        <div class="row">
            <div class="col-12  text-center">
                <h3 class="">Estatísticas</h3>
            </div>
            <div class="col-12 row">
                <h6 class="col-3">Mes com mais bilhetes vendidos:</h6>
                <h6 class="col-9">{{ $mesMaisRegistrosString }} : {{ $totalRegistrosMesMaisRegistros }} bilhetes vendidos.
                </h6>
                <hr>
            </div>
            <div class="col-12 row">
                <h6 class="col-3">Cliente com mais compras:</h6>
                <h6 class="col-9">{{ $nomeClienteComMaisRecibos }} : {{ $comprasClienteComMaisRecibos }} bilhetes comprados.
                </h6>
                <hr>
            </div>
            <div class="col-12 row">
                <h6 class="col-3">Filme mais vendido:</h6>
                <h6 class="col-9">{{ $tituloFilmeComMaisBilhetes }} : {{ $totalBilhetesFilmeComMaisBilhetes }} bilhetes
                    comprados.
                </h6>
                <hr>
            </div>
            <div class="col-12 row">
                <h6 class="col-3">Genero mais vendido:</h6>
                <h6 class="col-9">{{ $generoCodeComMaisBilhetes }} : {{ $totalBilhetesGeneroComMaisBilhetes }} bilhetes
                    comprados.
                </h6>
                <hr>
            </div>
            <div class="col-12 row">
                <h6 class="col-12">Lugares mais vendidos:</h6>
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">Sala</th>
                            <th scope="col">Fila</th>
                            <th scope="col">Posição</th>
                            <th scope="col">Total de Bilhetes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($top10Lugares as $lugar)
                            <tr>
                                <td>{{ $lugar->sala }}</td>
                                <td>{{ $lugar->fila }}</td>
                                <td>{{ $lugar->posicao }}</td>
                                <td>{{ $lugar->total_bilhetes }} bilhetes comprados</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endsection
