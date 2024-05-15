<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.14/lottie.min.js" integrity="sha384-H4W8nPR+5KOB07ztIflXJUMkq5Qk5wOIFCxYO/u53y8BOn/Eu3HHbTZFlGLNz59M" crossorigin="anonymous">

let img1 = '/imgs/night/icons8-sun-50.png';
let img2 = '/imgs/night/icons8-moon-symbol-50.png';
    </script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <style>
        body {
            margin: 0;
            position: relative;
        }
        img.falling {
            position: absolute;
            z-index: -1; /* Posição z mais atrás possível */
        }
        @keyframes rotateClockwise {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        @keyframes rotateCounterClockwise {
            from { transform: rotate(0deg); }
            to { transform: rotate(-360deg); }
        }
        .line, .dot {
    position: absolute;
    background: black;
    transition: transform 1s ease, opacity 1s ease;
    animation: colorChange 2s infinite; /* Animação de mudança de cor */
}

@keyframes colorChange {
    0% { background-color: rgb(255, 0, 0); }
    5% { background-color: yellow; }
    10% { background-color: rgb(183, 255, 0); }
    15% { background-color: rgb(30, 255, 0); }
    20% { background-color: rgb(0, 251, 255); }    0% { background-color: red; }
    25% { background-color: rgb(0, 51, 255); }
    30% { background-color: rgb(102, 0, 255); }
    35% { background-color: rgb(255, 0, 242); }
    40% { background-color: rgb(255, 0, 47); }
}

.line, .dot {
    position: absolute;
    background: black;
    transition: transform 1s ease, opacity 1s ease;
    animation: colorChange 2s infinite; /* Animação de mudança de cor */
}

.line {
    width: 5px; /* Ajuste para maior visibilidade da inclinação */
    height: 2px; /* Traço horizontal */
}

.dot {
    width: 5px;
    height: 5px;
    border-radius: 50%;
}



        .search-input {
            width: 200px;
        }

        @media (max-width: 1000.5px) {
            .search-input {
                width: 100%;
                margin-bottom: 10px;
                margin-right: 100px; /* Add some spacing below the search input */
            }
        }

        @media (max-width: 576px) {
            .search-input {
                width: 100%;
            }
        }

        #icon {
    display: inline-block;
    vertical-align: middle;
    width: 24px;
    height: 24px;
    margin-right: 8px;
}

.btn {
    display: inline-flex;
    align-items: center;
    vertical-align: middle;
}


    </style>

@vite(['resources/js/app.js'])

<link rel="stylesheet" href="css/style.css">


</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-custom-orange">
        <a class="navbar-brand" href="/">Cinematic</a>
        <div class="navbar-collapse" id="navbarSupportedContent">
            <form class="form-inline my-2 my-lg-0" action="{{ route('pesquisa') }}" method="POST">
                @csrf
                <input class="form-control mr-sm-2" type="search" name="titulo" placeholder="Pesquisar"
                    aria-label="Search">
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
                @if (Auth::check())
                    @if (Auth::user()->tipo != 'F')
                        <li class="nav-item">
                            <a class="nav-link" href="/historico" @php
$currentUrl = url()->current(); @endphp
                                @if ($currentUrl == url('/historico')) <a class="nav-link" href="#" style="color: orange;">Histórico</a>
                    @else
                        <a class="nav-link" href="#">Histórico</a> @endif
                                </a>
                        </li>
                    @endif
                @endif
                @if (Auth::check())
                @if (Auth::user()->tipo == 'F')
                    <li class="nav-item">
                        <a class="nav-link" href="/#" @php
$currentUrl = url()->current(); @endphp
                            @if ($currentUrl == url('/#')) <a class="nav-link" href="#" style="color: orange;">Controlo de Acesso à Sessão</a>
                    @else
                        <a class="nav-link" href="#">Controlo de Acesso à Sessão</a> @endif
                            </a>
                    </li>
                @endif
            @endif
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
                        <a class="nav-link" href="/#" @php
$currentUrl = url()->current(); @endphp
                            @if ($currentUrl == url('/#')) <a class="nav-link" href="#" style="color: orange;">Gerir utilizadores</a>
                    @else
                        <a class="nav-link" href="#">Gerir utilizadores</a> @endif
                            </a>
                    </li>
                @endif
            @endif

            @if (Auth::check())
            @if (Auth::user()->tipo == 'A')
                <li class="nav-item">
                    <a class="nav-link" href="/editarFilmes" @php
$currentUrl = url()->current(); @endphp
                        @if ($currentUrl == url('/editarFilmes')) <a class="nav-link" href="/editarFilmes" style="color: orange;">Editar Filmes</a>
                @else
                    <a class="nav-link" href="#">Editar Filmes</a> @endif
                        </a>
                </li>
            @endif
        @endif
            </ul>

            <ul class="navbar-nav ms-auto">
                @if (Auth::check())
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('carrinhoCompras') }}" @if ($currentUrl == url('/carrinhoCompras')) style="color: orange;"> @endif
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

    <button id="toggle-dark-mode" class="btn btn-primary" style="margin-left: 15px;">
        <img id="icon" alt="Toggle Dark Mode" style="width: 24px; height: 24px; margin-right: 8px;">
        <span id="toggle-text">Modo Noturno</span>
    </button>


    <div class="container base">
        @yield('content')
    </div>
    <footer class="mt-auto base">
        <div class="container text-center">

            <hr>
            <p>Feito por Artur Negru, João Bastos e João Ramos.</p>
            <p>A ideia do design é ser algo infantil e divertido e que crie uma memoria de utilização.</p>
            <hr>
        </div>
    </footer>






    <script>
'use strict';
// ao mudar de foco as animacoes param, para consumir menos recursos e para nao aparecerem demasiadas pipocas quando voltar ao foco
        let animationsActive = true;
        let animationFrameId;
        let intervalId;

        // Função para gerar um número aleatório entre dois valores
        function getRandomSize(min, max) {
            return Math.random() * (max - min) + min;
        }

        // Função para criar e posicionar as imagens aleatoriamente
        function createAndPositionImages() {
            const container = document.querySelector('body');

            // Loop para criar várias imagens
            for (let i = 0; i < 100; i++) {
                createImage(container);
            }
        }

        // Função para criar uma imagem individual
        function createImage(container) {
            const randomImg = Math.trunc(getRandomSize(1, 4));
            const image = document.createElement('img');
            image.src = `/imgs/popcorns/pipoca${randomImg}.png`;
            image.classList.add('falling');
            image.style.width = getRandomSize(1, 2) + 'cm'; // Tamanho aleatório entre 1 e 2 cm
            image.style.left = getRandomSize(0, window.innerWidth - 100) + 'px'; // Posição horizontal aleatória
            image.style.top = -getRandomSize(50, 200) + 'px'; // Posição vertical inicial fora do topo da tela

            // Adiciona rotação aleatória
            const rotateDirection = Math.random() < 0.5 ? 'rotateClockwise' : 'rotateCounterClockwise';
            const rotateDuration = getRandomSize(10, 20); // Duração aleatória entre 10 e 20 segundos
            image.style.animation = `${rotateDirection} ${rotateDuration}s linear infinite`;

            container.appendChild(image);
        }

        // Função para fazer as imagens caírem no ecrã
        function animateImages() {
            if (!animationsActive) return;

            const images = document.querySelectorAll('img.falling');

            images.forEach(image => {
                let top = parseFloat(image.style.top);
                top += 2; // Velocidade da queda

                // Atualizar a posição vertical da imagem
                image.style.top = top + 'px';

                // Reiniciar a posição da imagem se sair da tela
                if (top >= window.innerHeight-80) {
                    image.remove(); // Remove a imagem que saiu da tela
                }
            });

            animationFrameId = requestAnimationFrame(animateImages);
        }

        // Função para adicionar novas imagens continuamente
        function addImagesContinuously() {
            intervalId = setInterval(() => {
                if (!animationsActive) return;
                createImage(document.querySelector('body'));
            }, 1000); // Adiciona uma nova imagem a cada segundo
        }

        // Função para parar e reiniciar as animações
        function toggleAnimations() {
            animationsActive = !animationsActive;
            if (animationsActive) {
                animateImages();
                addImagesContinuously();
            } else {
                cancelAnimationFrame(animationFrameId);
                clearInterval(intervalId);
            }
        }

        // Event listeners para pausar e retomar animações ao mudar de janela
        window.addEventListener('blur', () => {
            animationsActive = false;
            cancelAnimationFrame(animationFrameId);
            clearInterval(intervalId);
        });

        window.addEventListener('focus', () => {
            animationsActive = true;
            animateImages();
            addImagesContinuously();
        });

//Ponteiro rato///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

        document.addEventListener('click', (event) => {
    createLinesAndDots(event.clientX, event.clientY);
});

function createLinesAndDots(x, y) {
    const container = document.querySelector('body');

    // Cria os traços
    for (let i = 0; i < 5; i++) {
        const line = document.createElement('div');
        line.classList.add('line');
        line.style.left = `${x}px`;
        line.style.top = `${y}px`;
        container.appendChild(line);

        // Direção e distância aleatória para os traços
        const angle = Math.random() * 2 * Math.PI;
        const distance = getRandomSize(50, 100);
        const translateX = Math.cos(angle) * distance;
        const translateY = Math.sin(angle) * distance;

        // Animação dos traços
        setTimeout(() => {
            line.style.transform = `translate(${translateX}px, ${translateY}px)`;
            line.style.transform += ` rotate(${angle}rad)`;
            line.style.opacity = 0;
        }, 0);

        // Remove o traço após a animação
        setTimeout(() => {
            line.remove();
        }, 1000);
    }

    // Cria os pontos
    for (let i = 0; i < 12; i++) {
        const dot = document.createElement('div');
        dot.classList.add('dot');
        dot.style.left = `${x}px`;
        dot.style.top = `${y}px`;
        container.appendChild(dot);

        // Direção e distância aleatória para os pontos
        const angle = Math.random() * 2 * Math.PI;
        const distance = getRandomSize(20, 50);
        const translateX = Math.cos(angle) * distance;
        const translateY = Math.sin(angle) * distance;

        // Animação dos pontos
        setTimeout(() => {
            dot.style.transform = `translate(${translateX}px, ${translateY}px)`;
            dot.style.opacity = 0;
        }, 0);

        // Remove o ponto após a animação
        setTimeout(() => {
            dot.remove();
        }, 1000);
        }
}

// Dark Mode///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////

const img1 = '/imgs/night/icons8-sun-50.png';
const img2 = '/imgs/night/icons8-moon-symbol-50.png';


document.addEventListener('DOMContentLoaded', (event) => {
        const toggleButton = document.getElementById('toggle-dark-mode');
        const body = document.body;
        const footer = document.querySelector('footer');
        const table = document.querySelector('table');
        const icon = document.getElementById('icon');
        const toggleText = document.getElementById('toggle-text');

        // Função para aplicar ou remover a classe dark-mode
        function applyDarkMode(enabled) {
            if (enabled) {
                body.classList.add('dark-mode');
                footer.classList.add('dark-mode');
                table.classList.add('dark-mode');
                icon.src =img1;// Caminho para o ícone do sol
                toggleText.textContent = 'Modo Claro';
            } else {
                body.classList.remove('dark-mode');
                footer.classList.remove('dark-mode');
                table.classList.remove('dark-mode');
                icon.src =img2;// Caminho para o ícone da lua
                toggleText.textContent = 'Modo Noturno';
            }
        }

        // Detecta se o browser está em modo noturno
        const prefersDarkScheme = window.matchMedia("(prefers-color-scheme: dark)").matches;

        // Verifica o estado do modo noturno na sessionStorage
        const darkMode = sessionStorage.getItem('darkMode');

        if (darkMode === 'enabled' || (darkMode !== 'disabled' && prefersDarkScheme)) {
            applyDarkMode(true);
        } else {
            applyDarkMode(false);
        }

        toggleButton.addEventListener('click', function () {
            const isDarkMode = body.classList.toggle('dark-mode');
            footer.classList.toggle('dark-mode');
            table.classList.toggle('dark-mode');

            if (isDarkMode) {
                sessionStorage.setItem('darkMode', 'enabled');
                icon.src = '/path/to/icons8-sun-50.png'; // Caminho para o ícone do sol
                toggleText.textContent = 'Modo Claro';
            } else {
                sessionStorage.setItem('darkMode', 'disabled');
                icon.src = '/path/to/icons8-moon-symbol-50.png'; // Caminho para o ícone da lua
                toggleText.textContent = 'Modo Noturno';
            }
        });
    });


        // Inicializar as funções
        createAndPositionImages();
        animateImages();
        addImagesContinuously();
        addImagesContinuously();
        addImagesContinuously();
        addImagesContinuously();
    </script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
