@extends('layout.base')
@php
$disabledStr = $readonlyData ?? false ? 'disabled' : '';
@endphp
@section('content')
@if (Auth::check())
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">User Profile</div>

                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <img src="{{ asset('storage/fotos/'. Auth::user()->foto_url) }}" alt="Profile Picture" class="img-fluid rounded-circle">
                            <br>
                            <br>
                            <p>User está bloqueado? @if (Auth::user()->bloqueado == '1')
                                Sim
                                @else
                                Não
                                @endif
                            </p>
                        </div>
                        <div class="col-md-8">
                            <label for="inputName" class="form-floating">Nome:</label>
                            <input type="text" class="form-group form-check @error('name') is-invalid @enderror" style="width:300px" name="name" id="inputName" {{ $disabledStr }} value="{{ Auth::user()->name }}">
                            <br>
                            <label for="inputEmail" class="form-floating">Mail:</label>
                            <input type="text" class="form-group form-check @error('email') is-invalid @enderror" style="width:250px" name="email" id="inputEmail" {{ $disabledStr }} value="{{ Auth::user()->email }}">
                            <br>

                           
                            
                            <p>Tipo de conta:</p>
                           
                            @csrf
                                <div class="input-group">

                                    <input type="text" class="form-control" value="{{ Auth::user()->tipo }}"  name="tipo" id="inputTipo" >

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
@endif
@endsection