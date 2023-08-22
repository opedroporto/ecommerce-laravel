<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset("css/site/index2.css") }}">
    <title>Login page</title>

    <style>
        .home{
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

    <section class="home">
        <div class="content">
            <h2>Comece a Fazer</h2>
            <p>Balelaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa</p>
            <a href="#">Começe agora!</a>
        </div>

        <div class="wrapper-login">

            <h2>Faça Login</h2>

            <form action="#">
                <div class="input-box">
                    <span class="icon"><ion-icon name="mail"></ion-icon></span>
                    <input type="email" required>
                    <label>Coloque seu email</label>
                </div>
                <div class="input-box">
                    <span class="icon"><ion-icon name="lock-closed"></ion-icon></span>
                    <input type="password" required>
                    <label>Coloque sua senha</label>
                </div>
                <div class="remember-forgot">
                    <label><input type="checkbox">Lembre de mim</label>
                    <a href="#">Esqueci a senha</a>
                </div>

                <button type="submit" class="btn">Login</button>
                <div class="register-link">
                    <p>Não tem conta?<a href="#">Crie uma agora</a></p>
                </div>

                
            </form>

        </div>


    </section>



    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>

    
</body>
</html>