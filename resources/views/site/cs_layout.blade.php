<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset("css/site/index2.css") }}">
    <title>Login page</title>

    <style>
        @font-face {
            font-family: "Outfit-Regular";
            src: url("{{ asset('css/fonts/Outfit-Regular.ttf') }}");
        }
        .home {
            background: url({{ asset("imgs/decoracao.jpeg") }}) no-repeat;
            background-size: cover;
            background-position: center;
        }
    </style>

</head>

<body>

    <header class="header">
        <a href="#" class="logo"><ion-icon name="balloon"></ion-icon>Decorações</a>
        <nav class="nav"> 
            <a href="#">Home</a>
            <a href="#">Sobre</a>
            <a href="#">Menu</a>
            <a href="#">Reviews</a>
            <a href="#">Contato</a>
        </nav>
    </header>


    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
</body>
</html>