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


        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&family=Roboto&display=swap" rel="stylesheet">

        <style>
            @font-face {
                font-family: 'Outfit', sans-serif;
                src: url("{{ asset('css/fonts/Outfit-Regular.ttf') }}");
            }
        </style>

        @stack("styles")

        {{-- Includes --}}
        @include("site.includes.loginpopup")

    </head>
    <body>
		{{-- <div class="topnav" id="myTopnav">
			<ul>
				<li id="left-nav">
					<div id="nav-detail"></div>
					<div class="logoWrapper" ><a href="{{ route("site.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpeg") }}" /></a></div>
				</li>
				<div id="right-nav">
						<li>
							<a href="{{ route("site.carrinho") }}"><i class="fa-solid fa-cart-shopping"></i> Carrinho</a>
							@if($quantidadeItemsCarrinho > 0)
								<div id="cart-counter">
									<span class="w3-badge">{{ $quantidadeItemsCarrinho }}</span>
								</div>
							@endif
						</li>
						@auth
						<li>
							<div class="dropdown">
								<button class="dropbtn">Olá, {{ Str::limit(auth()->user()->nome, 15) }}</button>
								<div class="dropdown-content">
									<a href="{{ route("site.getpedidos") }}" id="logout-btn"><i class="fa-solid fa-boxes-stacked"></i> Pedidos</a>
									<a href="{{ route("login.logout") }}" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
								</div>
							</div>
						</li>
						@else
							<li id="nav-login-btn"><a href="#"><i class="fa-solid fa-user"></i> Entrar</a></li>
						@endauth
				</div>
				<li class="icon">
					<a href="javascript:void(0);" onclick="myFunction()">
						<i class="fa fa-bars"></i>
					</a>
				</li>
            </ul>
		</div> --}}

        {{-- <nav id="top" class="top">
            <ul>
                <div id="left-nav">
                    <div id="nav-detail"></div>
                    <li class="logoWrapper" ><a href="{{ route("site.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpeg") }}" /></a></li>
                </div>
                <div id="right-nav">
                        <li>
                            <a href="{{ route("site.carrinho") }}"><i class="fa-solid fa-cart-shopping"></i> Carrinho</a>
                            @if($quantidadeItemsCarrinho > 0)
                                <div id="cart-counter">
                                    <span class="w3-badge">{{ $quantidadeItemsCarrinho }}</span>
                                </div>
                            @endif
                        </li>
                        @auth
						<li>
							<div class="dropdown">
								<button class="dropbtn">Olá, {{ Str::limit(auth()->user()->nome, 15) }}</button>
								<div class="dropdown-content">
									<a href="{{ route("site.getpedidos") }}" id="logout-btn"><i class="fa-solid fa-boxes-stacked"></i> Pedidos</a>
									<a href="{{ route("login.logout") }}" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
								</div>
							</div>
						</li>
                        @else
                            <li id="nav-login-btn"><a href="#"><i class="fa-solid fa-user"></i> Entrar</a></li>
                        @endauth
                </div>
				<li class="icon">
					<a href="javascript:void(0);"  onclick="myFunction()">
						<i class="fa fa-bars"></i>
					</a>
				</li>
            </ul>
        </nav> --}}

		<div class="nav">
			<input type="checkbox" id="nav-check">
			<div class="nav-header">
				<div id="nav-detail"></div>
				<li class="logoWrapper" ><a href="{{ route("site.index") }}"><img class="logo" src="{{ asset("imgs/fran.jpg") }}" /></a></li>
			</div>
			<div class="nav-btn">
				<label for="nav-check">
					<span></span>
					<span></span>
					<span></span>
				</label>
			</div>
			<div class="nav-links nav-links-left">
				<a href="{{ route("site.index") }}" class="nav-item-left">Fran Decorações</a>
			</div>
			<div class="nav-links nav-links-right">
				<a href="{{ route("site.carrinho") }}" class="nav-item">
					{{-- <i class="fa-solid fa-cart-shopping"></i>&nbsp;Carrinho --}}
					<i class="fa-solid fa-cart-shopping"></i>&nbsp;Carrinho
					@if($quantidadeItemsCarrinho > 0)
						&nbsp;
						<div id="cart-counter">
							<span class="w3-badge">{{ $quantidadeItemsCarrinho }}</span>
						</div>
					@endif
				</a>
				{{-- <a href="{{ route("site.sobre") }}" class="nav-item"><i class="fa-solid fa-shop"></i>&nbsp;Sobre</a> --}}
				<a href="{{ route("site.sobre") }}" class="nav-item"><i class="fa-solid fa-shop"></i>&nbsp;Sobre</a>
				@auth
				<div class="dropdown nav-item">
					<button class="dropbtn"><i class="fa-solid fa-user"></i>&nbsp;Olá, {{ Str::limit(auth()->user()->nome, 15) }}</button>
					<div class="dropdown-content">
						<a href="{{ route("site.perfil") }}" id="logout-btn"><i class="fa-solid fa-address-card"></i> Meus dados</a>
						<a href="{{ route("site.getpedidos") }}" id="logout-btn"><i class="fa-solid fa-boxes-stacked"></i> Pedidos</a>
						<a href="{{ route("login.logout") }}" id="logout-btn"><i class="fa-solid fa-arrow-right-from-bracket"></i> Sair</a>
					</div>
				</div>
				@else
					<a href="#" id="nav-login-btn" class="nav-item"><i class="fa-solid fa-user"></i>&nbsp;Entrar</a>
				@endauth
				{{-- <a href="//github.io/jo_geek" target="_blank">Github</a>
				<a href="http://stackoverflow.com/users/4084003/" target="_blank">Stackoverflow</a>
				<a href="https://in.linkedin.com/in/jonesvinothjoseph" target="_blank">LinkedIn</a>
				<a href="https://codepen.io/jo_Geek/" target="_blank">Codepen</a>
				<a href="https://jsfiddle.net/user/jo_Geek/" target="_blank">JsFiddle</a> --}}
			</div>
		</div>

        <main>
          @yield('content')
        </main>
    

        
		<footer class="footer">
		<div class="footer__addr">
			<p class="footer__title">
				<img class="footer__logo" src="{{ asset("imgs/fran.jpeg") }}" />
				Fran Decorações
			</p>
			{{-- <h2>Contato</h2> --}}
			<address>
			{{-- <i class="fa-solid fa-location-dot footer__btn"></i> {{ format_endereco(App\Models\Endereco::whereId(1)->first()) }}<br> --}}
			{{-- <i class="fa-brands fa-whatsapp footer__btn"></i> {{ App\Models\Usuario::whereId(1)->first()->tel }} --}}
			{{-- <a href="https://maps.google.com/?q={{ format_endereco(App\Models\Endereco::whereId(1)->first()) }}" target="__blank"><p><i class="fa-solid fa-location-dot"></i>&nbsp;{{ format_endereco(App\Models\Endereco::whereId(1)->first()) }}</p></a> --}}
			<a href="{{ getWhatsappLink(App\Models\Usuario::whereId(1)->first()->tel) }}" target="__blank"><p><i class="fa-brands fa-whatsapp"></i>&nbsp;{{ App\Models\Usuario::whereId(1)->first()->tel }}</p></a>
			<a href="mailto:{{ App\Models\Usuario::whereId(1)->first()->email }}" target="__blank"><p><i class="fa-solid fa-envelope"></i>&nbsp;{{ App\Models\Usuario::whereId(1)->first()->email }}</p></a>
			</address>
		</div>
		
		<ul class="footer__nav">
			<li class="nav__item">
				<h2 class="nav__title">Redes Sociais</h2>
				<ul class="nav__ul">
					<li>
						<a href="https://www.instagram.com/frandecoracoesepersonalizados"><i class="fa-brands fa-instagram" target="__blank"></i> @frandecoracoesepersonalizados</a>
					</li>
				</ul>
			</li>
			<li class="nav__item {{-- nav__item--extra --}}">
				<h2 class="nav__title">Links</h2>
				<ul class="nav__ul {{-- nav__ul--extra --}}"> 
					<li>
						<a href="{{ route("site.index") }}"><i class="fa-solid fa-house"></i> Página principal</a>
					</li>
					<li>
						<a href="{{ route("site.carrinho") }}"><i class="fa-solid fa-cart-shopping"></i> Carrinho</a>
					</li>
					<li>
						<a href="{{ route("site.sobre") }}"><i class="fa-solid fa-shop"></i> Quem somos</a>
					</li>
				</ul>
			</li>
			{{-- <li class="nav__item">
			<h2 class="nav__title">Legal</h2>
			<ul class="nav__ul">
				<li>
				<a href="#">Privacy Policy</a>
				</li>
				<li>
				<a href="#">Terms of Use</a>
				</li>
				<li>
				<a href="#">Sitemap</a>
				</li>
			</ul>
			</li> --}}
		</ul>
		
		<div class="legal">
			{{-- <p>&copy; {{ Carbon\Carbon::now()->format('Y') }}</p> --}}
			<div class="legal__links">
			<span>Feito por ZettaTech &copy; {{ Carbon\Carbon::now()->format('Y') }}</span>
			</div>
		</div>
		</footer>

		{{-- Jquery --}}
		<script src="{{ asset("js/jquery/jquery.js") }}"></script>

		{{-- All page scripts --}}
		<script src="{{ asset("js/script.js") }}"></script>

		{{-- Specific page scripts --}}
		@stack('scripts')
    </body>
</html>