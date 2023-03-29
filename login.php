<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <?php require('utilidades.php') ?>
</head>
<body id="bodyLogin">

    <h2 class="h2-login">BG Low Cost</h2>
    <div class="container" id="container">
        <div class="form-container sign-up-container">
            <form id="form-login" method="POST" action="">
                <h1 class="h1-login">Crea una cuenta</h1>
                <div class="social-container">
                    <a href="#" class="social a-login"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social a-login"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social a-login"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span class="span-login">o usa tu email para el registro</span>
                <input class="input-login" type="text" name="nameReg" placeholder="Name" />
                <input class="input-login" type="email" name="emailReg" placeholder="Email" />
                <input class="input-login" type="password" name="passReg" placeholder="Password" />
                <button class="btnUp button-login">Crear cuenta</button>
            </form>
        </div>
        <div class="form-container sign-in-container">
            <form id="form-login" method="POST" action="">
                <h1 class="h1-login">Iniciar Sesión</h1>
                <div class="social-container">
                    <a href="#" class="social a-login"><i class="fab fa-facebook-f"></i></a>
                    <a href="#" class="social a-login"><i class="fab fa-google-plus-g"></i></a>
                    <a href="#" class="social a-login"><i class="fab fa-linkedin-in"></i></a>
                </div>
                <span class="span-login">o usa tu cuenta</span>
                <input class="input-login" type="email" name="emailLog" placeholder="Email" />
                <input class="input-login" type="password" name="passLog" placeholder="Password" />
                <a href="#" class="a-login">Has olvidado la contraseña?</a>
                <button class="btnIn button-login">Iniciar Sesión</button>
            </form>
        </div>
        <div class="overlay-container">
            <div class="overlay">
                <div class="overlay-panel overlay-left">
                    <h1 class="h1-login">Bienvenido de vuelta!</h1>
                    <p class="p-login">Para mantenerte conectado con nosotros por favor inicia sesión con tu información personal</p>
                    <button class="ghost button-login" id="signIn">Iniciar Sesión</button>
                </div>
                <div class="overlay-panel overlay-right">
                    <h1 class="h1-login">Hola!</h1>
                    <p class="p-login">Introduce tus detalles personales y empieza con nosotros</p>
                    <button class="ghost button-login" id="signUp">Crear cuenta</button>
                </div>
            </div>
        </div>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

