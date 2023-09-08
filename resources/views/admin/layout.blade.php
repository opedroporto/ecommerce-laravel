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
        <link rel="stylesheet" href="{{ asset("css/admin/style.css") }}" />

        <style>
            @font-face {
                font-family: "Outfit-Regular";
                src: url("{{ asset('css/fonts/Outfit-Regular.ttf') }}");
            }
        </style>

        @stack("styles")
       
    </head>
    <body>
        <nav class="top">
            <ul>
                <div id="left-nav">
                    <div id="nav-detail"></div>
                    <li class="logoWrapper" ><a href="{{ route("admin.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpeg") }}" /></a></li>
                </div>
                <div id="right-nav">
                    <div class="dropdown">
                        <button class="dropbtn">Olá, {{ Str::limit(auth()->user()->nome, 15) }}</button>
                        <div class="dropdown-content">
                            <a href="{{ route("login.logout") }}" id="logout-btn">Sair <i class="fa-solid fa-arrow-right-from-bracket"></i></a>
                        </div>
                    </div>
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