<?php
    session_start();
    include("utilidades.php");
    $conn = conectarBDD();

    $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $usuario_id = $row["id"];
        }
    }

    if(isset($_POST["mensaje"]) && !empty($_POST["mensaje"])) {
        $mensaje = $_POST["mensaje"];

        $sql = "INSERT INTO mensajes(mensaje, fecha) VALUES('".$mensaje."', current_timestamp())";
        if (mysqli_query($conn, $sql)) {
            $gasolinera_id = $_SESSION["gasolinera"];

            $sql = "SELECT * from mensajes where mensaje='".$mensaje."' ORDER BY id DESC LIMIT 1;";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $mensaje_id = $row["id"];
                }
            }

            $sql = "INSERT INTO mensajes_usuarios(usuario_id, gasolinera_id, mensaje_id) VALUES(".$usuario_id.", ".$gasolinera_id.", ".$mensaje_id.")";
            if (mysqli_query($conn, $sql)) {
                header("Location: ./detalle_gasolinera.php");
                exit;
            }
            else {
                echo "<script>console.log('Error al guardar el mensajes con los usuarios: " . mysqli_error($conn). "');</script>";
            }
        } else {
            echo "<script>console.log('Error al guardar el mensaje: " . mysqli_error($conn). "');</script>";
        }

    }
    mysqli_close($conn);
?>