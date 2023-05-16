<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/700997539d.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body id="bodyLogin">

    <?php
        include("utilidades.php");
        $conn = conectarBDD();
    ?>

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
                <a href="../index.php">Continuar sin iniciar sesión</a>
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
                <a href="../index.php">Continuar sin iniciar sesión</a>
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

    <?php

        if(isset($_POST['nameReg'])) {
            // Obtener datos del formulario
            $nameReg = $_POST['nameReg'];
            $emailReg = $_POST['emailReg'];
            $passReg = $_POST['passReg'];

            // Encriptar la contraseña
            $hashed_password_register = password_hash($passReg, PASSWORD_DEFAULT);

            // Insertar datos en la tabla "usuarios"
            if($nameReg) {
                $sqlQuery = "SELECT count(*) as contador FROM usuarios WHERE nombre='".$nameReg."';";
                $result = mysqli_query($conn, $sqlQuery);

                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $sqlQuery2 = "SELECT count(*) as contador2 FROM usuarios WHERE correo='".$emailReg."';";
                    $result2 = mysqli_query($conn, $sqlQuery2);

                    if (mysqli_num_rows($result2) > 0) {
                        $row2 = mysqli_fetch_array($result2);

                        if($row['contador'] == 0 && $row2['contador2'] == 0) {
                            $stmt = $conn->prepare("INSERT INTO usuarios (nombre, correo, contraseña) VALUES (?, ?, ?)");
                            $stmt->bind_param("sss", $nameReg, $emailReg, $hashed_password_register);
                            $stmt->execute();

                            showMessage('success', 'Usuario registrado correctamente.', './login.php');
                        }
                        else {
                            showMessage('error', 'Ya existe alguien con ese nombre de usuario o correo.', './login.php');
                        }
                    }
                    
                }
            }
        }
        
        
        if(isset($_POST['emailLog'])) {
            $emailLog = $_POST['emailLog'];
            $passLog = $_POST['passLog'];

            // Encriptar la contraseña
            $hashed_password_login = password_hash($passLog, PASSWORD_DEFAULT);

            if($emailLog) {
                $sqlQuery = "SELECT contraseña FROM usuarios WHERE correo='".$emailLog."';";
                $result = mysqli_query($conn, $sqlQuery);
        
                if (mysqli_num_rows($result) > 0) {
                    $row = mysqli_fetch_array($result);
                    $hashed_password = $row['contraseña'];
                    if (password_verify($passLog, $hashed_password)) {
                        $_SESSION["correo"] = $emailLog;
                        header('Location: ./index.php');
                    } else {
                        showMessage('error', 'Correo electrónico o contraseña incorrecta.', './login.php');
                    }
                } else {
                    showMessage('error', 'Correo electrónico o contraseña incorrecta.', './login.php');
                }
            }
        }

        $conn->close();

    ?>

    <script src="scripts.js"></script>
    <script>
        localStorage.removeItem('ubicacionAceptada');
    </script>
</body>
</html>

