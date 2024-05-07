<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="css/style.css">
    <style>
    </style>

    @vite(['resources/js/app.js'])

</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-orange">
        <a class="navbar-brand" href="#">Cinematic</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0" action="{{ route('pesquisa') }}" method="POST">
                @csrf
                <input class="form-control mr-sm-2" type="search" name="titulo" placeholder="Pesquisar"
                    aria-label="Search">
                <!-- Seu botão de pesquisa -->
                <button class="btn btn-outline-dark my-2 my-sm-0" type="submit">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-search" viewBox="0 0 16 16">
                        <path
                            d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0" />
                    </svg>
                </button>
            </form>
        </div>

    </nav>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="/filmes" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/filmes')) <a class="nav-link" href="#" style="color: orange;">Filmes</a>
                    @else
                        <a class="nav-link" href="#">Filmes</a> @endif
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/historico" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/historico')) <a class="nav-link" href="#" style="color: orange;">Histórico</a>
                    @else
                        <a class="nav-link" href="#">Histórico</a> @endif
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/historico" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/historico')) <a class="nav-link" href="#" style="color: orange;">Controlo de Acesso à Sessão</a>
                    @else
                        <a class="nav-link" href="#">Controlo de Acesso à Sessão</a> @endif
                        </a>
                </li>
                @if (Auth::check())
                    @if (Auth::user()->tipo == 'A')
                        <li class="nav-item">
                            <a class="nav-link" href="/estatistica" @php
$currentUrl = url()->current(); @endphp
                                @if ($currentUrl == url('/estatistica')) <a class="nav-link" href="#" style="color: orange;">Estatística</a>
                        @else
                            <a class="nav-link" href="#">Estatística</a> @endif
                                </a>
                        </li>
                    @endif
                @endif

                @if (Auth::check())
                    @if (Auth::user()->tipo == 'A')
                        <li class="nav-item">

                            <a class="nav-link" href="#">Gerir utilizadores</a>

                        </li>
                    @endif
                @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('carrinhoCompras') }}">
                            <span>Carrinho de compras</span>
                            @php
                                $carrinhoCount = count(session('carrinho', []));
                            @endphp
                            @if ($carrinhoCount > 0)
                                <span class="badge badge-pill badge-primary">
                                    <span class="badge-circle">{{ $carrinhoCount }}</span>
                                </span>
                            @endif
                        </a>
                    </li>


                @endif
                @guest
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </li>
                    @endif

                    @if (Route::has('register'))
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Sign In') }}</a>
                        </li>
                    @endif
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                            @if (Auth::check())
                                @if (Auth::user()->tipo != 'F')
                                    <a class="dropdown-item" href="" onclick="event.preventDefault();">

                                        {{ __('Perfil de Utilizador') }}
                                    </a>
                                @endif
                            @endif
                            <a class="dropdown-item" href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </nav><br>
    <div class="container">
        @yield('content')
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
