<?php
session_start();

// Verifica si se ha enviado un archivo
if(isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
    // Define el directorio donde se guardarán las imágenes
    $directorio = "perfiles/foto/"; // Reemplaza con la ruta real a tu directorio de guardado

    // Obtiene el nombre y la extensión del archivo enviado
    $nombreArchivo = $_FILES["foto_perfil"]["name"];
    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

    $email = $_SESSION['correo']; 
    $partes = explode("@", $email);
    $nombreUsuario = $partes[0];

    // Genera el nombre único de la imagen utilizando el nombre de usuario
    $nombreUnico = $nombreUsuario . '.' . $extension;

    // Mueve el archivo temporal a su ubicación final
    if(move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $directorio . $nombreUnico)) {
        // El archivo se ha guardado exitosamente
        echo "La imagen se ha guardado correctamente.";
    } else {
        // Hubo un error al guardar el archivo
        echo "Ha ocurrido un error al guardar la imagen.";
    }
} else {
    // No se ha enviado ningún archivo
    echo "No se ha seleccionado ninguna imagen.";
}
header("Location: perfil.php");
?>
