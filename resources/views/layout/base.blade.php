<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            background-color: #dbdbdbeb;
            /* Cor de fundo para a página */
            color: #000;
            /* Cor do texto para a página */
        }

        h1 {
            color: #000;
            margin-left: 100px;

        }

        p {
            /* Adicionar estilo */
        }


        .bg-custom-orange {
            background-color: #ffcc00eb;
            /* Código hexadecimal para laranja */
        }

        .navbar-brand {
            font-family: "Helvetica Neue", sans-serif;
            /* Exemplo de fonte moderna */
            color: #000;
            /* Cor preta */
            margin-left: 60px;
            /* Adiciona uma margem à esquerda de 20 pixels */
            font-size: 40px;
            /* Tamanho da fonte */
            font-weight: bold
        }

        .navbar-collapse input[type="search"]::placeholder {
            color: #000000;
            /* Texto do placeholder em branco */
        }

        /*Tamanho da barra de pesquisa*/
        .form-inline {
            width: 80%;
            /* Defina o comprimento desejado para o formulário */
        }

        .form-control mr-sm-2 {
            background-color: #d0a600eb;
            /* Fundo preto */
            border-radius: 9px;
            /* Raio de borda para tornar o formulário arredondado */
            display: flex;
            align-items: center;
            margin-right: 15px;
            /* Adiciona um espaço à direita */
        }


        .navbar-collapse form {
            display: flex;
            align-items: center;
            margin-left: 70%;
            margin-right: 10%
        }

        .navbar-collapse input[type="search"] {
            background-color: #d0a600eb;
            color: #000000;
            border: none;
            padding: 0.5rem;
        }

        .navbar-collapse button[type="submit"] {
            margin-left: 10px;
            /* Margem à esquerda para separar o botão do campo de pesquisa */
        }

        .nav-link {
            font-family: "Helvetica Neue", sans-serif;
            /* Exemplo de fonte moderna */
            color: #ffffff;
        }

        /* Media query para telas menores que 768px */
        @media screen and (max-width: 768px) {
            .form-inline {
                width: 0px;
                /* Defina o comprimento desejado para o formulário */
            }
        }

        /* Media query para telas menores que 576px */
        @media screen and (max-width: 578px) {
            .form-inline {
                width: 0px;
                /* Defina o comprimento desejado para o formulário */
            }
        }
    </style>
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
                        @if ($currentUrl == url('/historico')) <a class="nav-link" href="#" style="color: orange;">Filmes</a>
                    @else
                        <a class="nav-link" href="#">Histórico</a> @endif
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/historico" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/historico')) <a class="nav-link" href="#" style="color: orange;">Filmes</a>
                    @else
                        <a class="nav-link" href="#">Controlo de Acesso à Sessão</a> @endif
                        </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/estatistica" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/estatistica')) <a class="nav-link" href="#" style="color: orange;">Filmes</a>
                    @else
                        <a class="nav-link" href="#">Estatística</a> @endif
                        </a>
                </li>
            </ul>
        </div>
    </nav>
    <div class="container">
        @yield('content')
    </div>
</body>

</html>
