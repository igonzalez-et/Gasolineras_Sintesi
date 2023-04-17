<?php
session_start();

// Verifica si se ha enviado un archivo
if(isset($_FILES["foto_perfil"]) && $_FILES["foto_perfil"]["error"] == 0) {
    // Define el directorio donde se guardarán las imágenes
    $directorio = "perfiles/foto/"; // Reemplaza con la ruta real a tu directorio de guardado

    // Obtiene el nombre y la extensión del archivo enviado
    $nombreArchivo = $_FILES["foto_perfil"]["name"];

    $extension = pathinfo($nombreArchivo, PATHINFO_EXTENSION);

    // Mueve el archivo temporal a su ubicación final
    if(move_uploaded_file($_FILES["foto_perfil"]["tmp_name"], $directorio . $nombreArchivo)) {
        // El archivo se ha guardado exitosamente
        echo "La imagen se ha guardado correctamente.";

        $servername = "localhost";
        $username = "igonzalez";
        $password = "Superlocal123";
        $dbname = "BGLC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);

        // Verificar conexión
        if (!$conn) {
            die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
        }

        $stmt = $conn->prepare("UPDATE usuarios SET foto = ? WHERE correo = ?");
        $stmt->bind_param("ss", $nombreArchivo, $_SESSION["correo"]);
        $stmt->execute();

        $conn->close();

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
