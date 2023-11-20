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
        {{-- <div class="header"></div> --}}
        <nav class="header top">
            <ul>
                <div id="left-nav">
                    <div id="nav-detail"></div>
                    {{-- <li class="logoWrapper" ><a href="{{ route("admin.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpeg") }}" /></a></li> --}}
                </div>
                <div id="right-nav">
                    <div class="dropdown" style="float:right;">
                        <button class="dropbtn"><a href="#">Olá, {{ Str::limit(auth()->user()->nome, 15) }}&nbsp;&nbsp;<i class="fa-solid fa-angle-down"></i></a></button>
                        <div class="dropdown-content">
                            <a href="{{ route("login.logout") }}" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
                        </div>
                    </div>
                </div>
            </ul>
        </nav>

        <input type="checkbox" class="openSidebarMenu" id="openSidebarMenu">
        <label for="openSidebarMenu" class="sidebarIconToggle">
            <div class="spinner diagonal part-1"></div>
            <div class="spinner horizontal"></div>
            <div class="spinner diagonal part-2"></div>
        </label>
        
        <div id="sidebarMenu">
            <ul class="sidebarMenuInner">
                <li><a href="{{ route("admin.index") }}"><i class="fa-solid fa-house"></i> Painel de controle</a></li>
                <div id="crud-items">
                    <li><a href="{{ route("admin.pedidos.index") }}"><i class="fa-solid fa-cart-shopping"></i> Pedidos</a></li>
                    <li><a href="{{ route("admin.produtos.index") }}"><i class="fa-solid fa-box"></i> Produtos</a></li>
                    <li><a href="{{ route("admin.colecoes.index") }}"><i class="fa-solid fa-boxes-stacked"></i> Decorações</a></li>
                    <li><a href="{{ route("admin.categorias.index") }}"><i class="fa-solid fa-table-cells-large"></i> Categorias</a></li>
                    <li><a href="{{ route("admin.usuarios.index") }}"><i class="fa-solid fa-user"></i> Usuários</a></li>
                    <li><a href="{{ route("admin.enderecos.index") }}"><i class="fa-solid fa-location-dot"></i> Endereços</a></li>
                </div>
                <li><a class="grey" href="{{ route("login.logout") }}"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a></li>
            </ul>
        </div>
  {{-- <div id='center' class="main center">
    <div class="mainInner">
      <div>PURE CSS SIDEBAR TOGGLE MENU</div>
    </div>
    <div class="mainInner">
      <div>PURE CSS SIDEBAR TOGGLE MENU</div>
    </div>
    <div class="mainInner">
      <div>PURE CSS SIDEBAR TOGGLE MENU</div>
    </div>
  </div> --}}
 
        {{-- <nav class="top">
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
        </nav> --}}

        <main>
            @yield('content')
        </main>
    
    </body>

    {{-- Jquery --}}
    <script src="{{ asset("js/jquery/jquery.js") }}"></script>

    {{-- All page scripts --}}
    <script src="{{ asset("js/script.js") }}"></script>

    <script>
        $(".sidebarMenuInner li").hover(function() {
            console.log($(".sidebarMenuInner li").not(this));
            $(".sidebarMenuInner li").not(this).addClass("inactive");
        }, function() {
            $(".sidebarMenuInner li").not(this).removeClass("inactive");
        });
    </script>

    {{-- Specific page scripts --}}
    @stack('scripts')

</html>
