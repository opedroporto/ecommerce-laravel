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
        <link rel="stylesheet" href="{{ asset("css/password/style.css") }}" />


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
        <main>
          @yield('content')
        </main>

		{{-- Jquery --}}
		<script src="{{ asset("js/jquery/jquery.js") }}"></script>

		{{-- All page scripts --}}
		<script src="{{ asset("js/script.js") }}"></script>

		{{-- Specific page scripts --}}
		@stack('scripts')
    </body>
</html>