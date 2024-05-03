@php
$disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Profile</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/fotos/'.$user->foto_url) }}" alt="Profile Picture" class="img-fluid rounded-circle">
                            <br>
                            <br>
                            <p>User está bloqueado? @if($user->bloqueado == 1)
                                Sim
                                @else
                                Não
                                @endif
                            </p>
                        </div>
                        <div class="col-md-8">
                            <label for="inputName" class="form-floating">Nome:</label>
                            <input type="text" class="form-group form-check @error('name') is-invalid @enderror" style="width:300px" name="name" id="inputName" {{ $disabledStr }} value="{{ old('name', $user->name) }}">
                            <br>
                            <label for="inputEmail" class="form-floating">Mail:</label>
                            <input type="text" class="form-group form-check @error('email') is-invalid @enderror" style="width:250px" name="email" id="inputEmail" {{ $disabledStr }} value="{{ old('email', $user->email) }}">
                            <br>
                            @if($user->tipo=='C')
                            @if($user->cliente->nif != NULL)
                            <p>Nif: {{ $user->cliente->nif }}</p>
                            @endif
                            <br>
                            @if ($user->cliente->tipo_pagamento != NULL)
                            <p>Tipo de pagamento preferido: {{ $user->cliente->tipo_pagamento }}</p>
                            @endif
                            <br>

                            @endif
                            <p>Tipo de conta:</p>
                            <form action="{{ route('alterarTipo')}}" method="POST">
                            @csrf
                                <div class="input-group">

                                    <input type="text" class="form-control" value="{{ old('tipo', $user->tipo) }}"  name="tipo" id="inputTipo" >

                                    <button type="submit" class="btn btn-default">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>

                                    </div>
                                </div>
                            </form>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>