<?php

    include("utilidades.php");
    $conn = conectarBDD();

    $commentId = $_POST['commentId'];
    $newCommentText = $_POST['newCommentText'];

    $sql = "UPDATE mensajes SET mensaje = '$newCommentText' WHERE id = '$commentId'";
    if (mysqli_query($conn, $sql)) {
        echo "Comentario actualizado correctamente";
    } else {
        echo "Error al actualizar el comentario: " . mysqli_error($conn);
    }

    mysqli_close($conn);
    header("Location: detalle_gasolinera.php");
?>
