<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title") | Fran Decorações</title>

        <link rel="icon" type="image/x-icon" href="{{ asset("favicon.ico") }}">

        <link rel="stylesheet" href="{{ asset("css/fontawesome/css/all.min.css") }}" />
        <link rel="stylesheet" href="{{ asset("css/reset.css") }}" />
        <link rel="stylesheet" href="{{ asset("css/variables.css") }}" /> 
        <link rel="stylesheet" href="{{ asset("css/site/style.css") }}" />

        <style>
            @font-face {
                font-family: "Outfit-Regular";
                src: url("{{ asset('css/fonts/Outfit-Regular.ttf') }}");
            }
        </style>

        @stack("styles")

        

        {{-- Includes --}}
        @include("site.includes.loginpopup")

    </head>
    <body>
        <nav class="top">
            <ul>
                <div id="left-nav">
                        <div id="nav-detail"></div>
                        <li class="logoWrapper" ><a href="{{ route("site.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpeg") }}" /></a></li>
                </div>
                <div id="right-nav">
                        <li>
                            <a href="{{ route("site.carrinho") }}"><i class="fa-solid fa-cart-shopping"></i> Carrinho</a>
                            {{-- @if(\Cart::getContent()->count() > 0) --}}
                            @if($quantidadeItemsCarrinho > 0)
                                <div id="cart-counter">
                                    <span class="w3-badge">{{ $quantidadeItemsCarrinho }}</span>
                                </div>
                            @endif
                        </li>
                        @auth
                        <div class="dropdown">
                            <button class="dropbtn">Olá, {{ Str::limit(auth()->user()->nome, 15) }}</button>
                            <div class="dropdown-content">
                                <a href="{{ route("site.getpedidos") }}" id="logout-btn">Pedidos <i class="fa-solid fa-boxes-stacked"></i></a>
                                <a href="{{ route("login.logout") }}" id="logout-btn">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                            </div>
                        </div>
                        @else
                            <li id="nav-login-btn"><a href="#"><i class="fa-solid fa-user"></i> Entrar</a></li>
                        @endauth
                </div>
            </ul>
        </nav>

        @yield('content')
    
    </body>

    {{-- Jquery --}}
    <script src="{{ asset("js/jquery/jquery.js") }}"></script>

    {{-- All page scripts --}}
    <script src="{{ asset("js/script.js") }}"></script>

    {{-- Specific page scripts --}}
    @stack('scripts')

</html>