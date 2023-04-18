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

    <title>Perfil</title>

</head>
<body id="bodyPerfil">
    <?php include("./includes/header.php")?>

    <?php
        $servername = "localhost";
        $username = "igonzalez";
        $password = "Superlocal123";
        $dbname = "BGLC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verificar conexión
        if (!$conn) {
            die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
        }

        $sqlQuery = "SELECT foto FROM usuarios WHERE correo='".$_SESSION['correo']."';";
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $foto = $row['foto'];
            if(!$foto){
                $foto = "default.png";
            }
            $rutaImagenGuardada = "./perfiles/foto/".$foto;
            
        } else {
            echo "No existe este usuario.";
        }

    
        // if (!file_exists($rutaImagenGuardada)) {
        //     $rutaImagenGuardada = "./perfiles/foto/default.png";
        // }
    ?>
    <div class="datosPerfil">
        <div class="imagenPerfil">
            <form action="guardar_imagen.php" method="POST" enctype="multipart/form-data">
                <div class="contenedorFotoPerfil">
                    <img src=<?php echo "'".$rutaImagenGuardada."'"; ?> id="previewFotoPerfil" alt="Foto de perfil actual" class="FotoPerfil">
                    <label for="inpFotoPerfil" class="overlayFotoPerfil">
                        <span>Seleccionar imagen nueva</span>
                    </label>
                    <input type="file" id="inpFotoPerfil" name="foto_perfil" style="display:none;">
                </div>
                <input type="submit" value="Guardar" id="btnGuardar" style="display:none;">
            </form>
        </div>
        <div class="descripcionPerfil">
            
        </div>
    </div>


    <script src="scripts.js"></script>
</body>
</html>
