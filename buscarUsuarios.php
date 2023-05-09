<?php
    session_start();
    include("utilidades.php");
    $conn = conectarBDD();

    $nombre = $_POST['nombre'];

    $sql = "SELECT * FROM usuarios WHERE nombre LIKE '%$nombre%'";
    $resultado = mysqli_query($conn, $sql);

    if (mysqli_num_rows($resultado) > 0) {
        echo "<table>";
        echo "<tr><th>Nombre</th></tr>";
        while ($row = mysqli_fetch_assoc($resultado)) {
            
            $sql2 = "SELECT nombre FROM usuarios WHERE correo = '".$_SESSION['correo']."';";
            $resultado2 = mysqli_query($conn, $sql2);

            if (mysqli_num_rows($resultado2) > 0) {
                while ($row2 = mysqli_fetch_assoc($resultado2)) {
                    // Comprobar que sea diferente usuario que la sesión
                    if($row['nombre'] != $row2['nombre']) {
                        $foto = $row['foto'];
                        if(!$foto){
                            $foto = "default.png";
                        }
                        echo "<tr>";
                        echo "<td><a href='../perfil.php?usuario=".$row['nombre']."'><img src='./perfiles/foto/". $foto ."' alt='Foto de perfil de usuario'>" . $row['nombre'] . "</a></td>";
                        echo "</tr>";
                    }
                }
            }

            
        }
        echo "</table>";
    } else {
        echo "No se encontraron resultados.";
    }

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);
?>