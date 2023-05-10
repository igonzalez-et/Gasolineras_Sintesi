<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./utilities.js"></script>

    <title>Perfil</title>

</head>
<body id="bodyPerfil">
    <?php 
        include("./includes/header.php");
    ?>
    <?php
        $usuario = $_GET['usuario'];
        
        $sqlQuery = "SELECT * FROM usuarios WHERE nombre='".$usuario."';";
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $usuario_id = $row['id'];
            $foto = $row['foto'];
            $nombre = $row['nombre'];
            $privacidad = $row['privacidad'];
            if(!$foto){
                $foto = "default.png";
            }
            $rutaImagenGuardada = "./perfiles/foto/".$foto;
            
        } else {
            echo "No existe este usuario.";
        }

        $sqlQuery = "SELECT * FROM usuarios WHERE correo='".$_SESSION['correo']."';";
        $result = mysqli_query($conn, $sqlQuery);
        $local = false;
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            if($row['nombre'] == $usuario) {
                $local = true;
            }
        }

        $sqlQuery = "select count(*) as contadorFavoritas from gasolineras g inner join favoritos_gasolinera fg on g.id = fg.gasolinera_id where fg.usuario_id =".$usuario_id;
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $favoritas = $row['contadorFavoritas'];
        }

    ?>
    <div class="datosPerfil">
        <div class="imagenPerfil">
            <div class="contenedorFotoPerfil">
                <img src=<?php echo "'".$rutaImagenGuardada."'"; ?> id="previewFotoPerfil" alt="Foto de perfil actual" class="FotoPerfil">
            </div>
        </div>
        <div class="descripcionPerfil">
            <?php
                echo "<p>".$nombre."</p>";
                echo "<p> Favoritas ".$favoritas."</p>";
                if($local) {
                    echo "<a href='./configuracion.php'>Configuración</a>";
                }
            ?>

        </div>
    </div>

    <?php
        if($local) {
            include("./includes/gasolineras_favoritas.php");
        }
        else {
            if($privacidad == "publico") {
                include("./includes/gasolineras_favoritas_visitante.php");
            }
            else {
                echo "Este usuario es privado.";
            }

            // Añadir el usuario buscado al array
            if(!isset($_SESSION['arrayRecientes'])) {
                $_SESSION['arrayRecientes'] = array();
            }
            if (in_array($usuario, $_SESSION['arrayRecientes'])) {
                $key = array_search($usuario, $_SESSION['arrayRecientes']);
                unset($_SESSION['arrayRecientes'][$key]);
                array_unshift($_SESSION['arrayRecientes'], $usuario);
            } else {
                array_unshift($_SESSION['arrayRecientes'], $usuario);
            }
        }

    ?>

    <script src="scripts.js"></script>
</body>
</html>
