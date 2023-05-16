<?php
    include("utilidades.php");
    $conn = conectarBDD();

    $commentId = $_POST['commentId'];

    $sql = "DELETE FROM mensajes_usuarios WHERE mensaje_id = '$commentId'";
    if (mysqli_query($conn, $sql)) {
        echo "Mensaje_usuario eliminado correctamente";
    } else {
        echo "Error al actualizar el comentario: " . mysqli_error($conn);
    }

    $sql2 = "DELETE FROM mensajes WHERE id = '$commentId'";

    if (mysqli_query($conn, $sql2)) {
        echo "Comentario eliminado correctamente";
    } else {
        echo "Error al actualizar el comentario: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: detalle_gasolinera.php");
?>