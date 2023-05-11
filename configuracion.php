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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./utilities.js"></script>

    <title>Configuración</title>
</head>
<body id="bodyConfiguracion">
    <?php 
        include("./includes/header.php");

        $correo = $_SESSION['correo'];
        $sqlQuery = "SELECT * FROM usuarios WHERE correo='".$correo."';";
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $usuario_id = $row['id'];
            $nombre = $row['nombre'];
            $privacidad = $row['privacidad'];
            $hashed_password = $row['contraseña'];
        }

        // Verificar si el formulario ha sido enviado
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // Obtener los datos enviados desde el formulario
            $nuevo_nombre = $_POST['nuevo_nombre'];
            $nuevo_correo = $_POST['nuevo_correo'];
            $nueva_contrasena = $_POST['nueva_contrasena'];
            $confirmar_contrasena = $_POST['confirmar_contrasena'];
            $privacidad = $_POST['privacidad'];

            // Validar los datos del formulario
            $errores = array();
            if (empty($nuevo_nombre)) {
                $errores[] = "El nombre es requerido.";
            }
            if (empty($nuevo_correo)) {
                $errores[] = "El correo electrónico es requerido.";
            }
            if (!filter_var($nuevo_correo, FILTER_VALIDATE_EMAIL)) {
                $errores[] = "El correo electrónico no es válido.";
            }
            if (!empty($nueva_contrasena) && ($nueva_contrasena != $confirmar_contrasena) || empty($nueva_contrasena || empty($confirmar_contrasena))) {
                $errores[] = "Las contraseñas no coinciden.";
            }
            if (password_verify($nueva_contrasena, $hashed_password)) {
                $errores[] = "No puedes poner la misma contraseña.";
            }


            // Si no hay errores, actualizar los datos del usuario en la base de datos
            if (empty($errores)) {

                $_SESSION['correo'] = $nuevo_correo;

                // Escapar los datos para evitar inyección de SQL
                $nuevo_nombre = mysqli_real_escape_string($conn, $nuevo_nombre);
                $nuevo_correo = mysqli_real_escape_string($conn, $nuevo_correo);
                $nueva_contrasena = mysqli_real_escape_string($conn, $nueva_contrasena);

                // Si la contraseña no ha sido cambiada, no actualizarla

                if (empty($nueva_contrasena)) {
                    $query = "UPDATE usuarios SET nombre = '$nuevo_nombre', correo = '$nuevo_correo', privacidad = '$privacidad' WHERE id = '$usuario_id'";
                } else {
                    $contrasena = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
                    // En caso contrario, actualizar la contraseña también
                    $query = "UPDATE usuarios SET nombre = '$nuevo_nombre', correo = '$nuevo_correo', contraseña = '$contrasena', privacidad = '$privacidad' WHERE id = '$usuario_id'";
                }

                // Ejecutar la consulta SQL
                mysqli_query($conn, $query);

                // Cerrar la conexión a la base de datos
                mysqli_close($conn);

                // Redirigir al usuario a la página de perfil
                header("Location: perfil.php?usuario=".$nombre."");
            }
            else {
                foreach ($errores as $error) {
                    echo $error."<br>";
                }
            }
        }
    ?>

    <?php
        $sqlQuery = "SELECT * FROM usuarios WHERE correo='".$_SESSION['correo']."';";
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $usuario_id = $row['id'];
            $foto = $row['foto'];
            $nombre = $row['nombre'];
            if(!$foto){
                $foto = "default.png";
            }
            $rutaImagenGuardada = "./perfiles/foto/".$foto;
            
        } else {
            echo "No existe este usuario.";
        }
    ?>
    <div class="contenedorConfiguracion">
        <h2>Configuración del perfil</h2>
        <form action="guardar_imagen.php" method="POST" enctype="multipart/form-data">
            <div class="contenedorFotoPerfilConfiguracion">
                <img src=<?php echo "'".$rutaImagenGuardada."'"; ?> id="previewFotoPerfil" alt="Foto de perfil actual" class="FotoPerfil">
                <label for="inpFotoPerfil" class="overlayFotoPerfil">
                    <span>Seleccionar imagen nueva</span>
                </label>
                <input type="file" id="inpFotoPerfil" name="foto_perfil" style="display:none;">
            </div>
            <input type="submit" value="Cambiar imagen" id="btnGuardar" style="display:none;">
        </form>

        <form id="formConfig" method="post" action="">

            <label for="nuevo_nombre">Nombre de usuario:</label>
            <input type="text" name="nuevo_nombre" value="<?php echo $nombre; ?>"><br>

            <label for="nuevo_correo">Correo electrónico:</label>
            <input type="email" name="nuevo_correo" value="<?php echo $correo; ?>"><br>

            <label for="nueva_contrasena">Nueva contraseña:</label>
            <input type="password" name="nueva_contrasena"><br>

            <label for="confirmar_contrasena">Confirmar contraseña:</label>
            <input type="password" name="confirmar_contrasena"><br>

            <label for="privacidad">Privacidad:</label>
            <select name="privacidad">
                <option value="publico" <?php if ($privacidad == 'publico') { echo 'selected';} ?>>Público</option>
                <option value="privado" <?php if ($privacidad == 'privado') { echo 'selected';} ?>>Privado</option>
            </select><br>

            <input type="submit" value="Guardar cambios">
        </form>
    </div>
    <script src="scripts.js"></script>
</body>
</html>

