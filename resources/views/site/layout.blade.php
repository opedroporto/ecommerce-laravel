<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>@yield("title") | Fran Decorações</title>

        <link rel="icon" type="image/x-icon" href="{{ asset("favicon.ico") }}">
        
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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
                            <span>Olá, {{ Str::limit(auth()->user()->nome, 25) }}</span>
                            <div class="dropdown-content">
                                <a href="{{ route("login.logout") }}" id="logout-btn">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                            </div>
                        </div>
                        @else
                            <li id="nav-login-btn"><a href="#"><i class="fa-solid fa-user"></i> Entrar</a></li>
                        @endauth
                </div>
            </ul>
        </nav>

        {{-- Includes --}}
        @include("site.includes.loginpopup")

    </head>
    <body>

        @yield('content')
    
    </body>

    {{-- Jquery --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.0/jquery.js" integrity="sha512-8Z5++K1rB3U+USaLKG6oO8uWWBhdYsM3hmdirnOEWp8h2B1aOikj5zBzlXs8QOrvY9OxEnD2QDkbSKKpfqcIWw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    {{-- All page scripts --}}
    <script src="{{ asset("js/site/script.js") }}"></script>

    {{-- Specific page scripts --}}
    @stack('scripts')

</html>