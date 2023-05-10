<?php
    session_start();
    include("utilidades.php");
    $conn = conectarBDD();

    $nombre = $_POST['nombre'];

    echo "<table>";
    if($_POST['nombre'] != "") {
        $sql = "SELECT * FROM usuarios WHERE nombre LIKE '%$nombre%' and correo != '".$_SESSION['correo']."';";
        $resultado = mysqli_query($conn, $sql);
    
        if (mysqli_num_rows($resultado) > 0) {
            echo "<tr><th>Resultados búsqueda</th></tr>";
            while ($row = mysqli_fetch_assoc($resultado)) {
                $foto = $row['foto'];
                if(!$foto){
                    $foto = "default.png";
                }

                echo "<tr>";
                echo "<td><a href='../perfil.php?usuario=".$row['nombre']."'><img src='./perfiles/foto/". $foto ."' alt='Foto de perfil de usuario'>" . $row['nombre'] . "</a></td>";
                echo "</tr>";
                $encontrados = True;
                
            }
            
        } else {
            echo "No se encontraron resultados.";
        }
    }
    else {
        if(isset($_SESSION['arrayRecientes']) && count($_SESSION['arrayRecientes']) > 0) {
            echo "<tr><th>Búsquedas recientes</th></tr>";
            
            foreach ($_SESSION['arrayRecientes'] as $reciente) {
                $sql2 = "SELECT * FROM usuarios WHERE nombre = '".$reciente."';";
                $resultado2 = mysqli_query($conn, $sql2);
            
                if (mysqli_num_rows($resultado2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($resultado2)) {
                        if($reciente == $row2['nombre']) {
                            $foto = $row2['foto'];
                            if(!$foto){
                                $foto = "default.png";
                            }
                            echo "<tr>";
                            echo "<td><a href='../perfil.php?usuario=".$row2['nombre']."'><img src='./perfiles/foto/". $foto ."' alt='Foto de perfil de usuario'>" . $row2['nombre'] . "</a></td>";
                            echo "</tr>";
                        }
                    }
                }
            }
        }
    }
    echo "</table>";

    

    // Cerrar la conexión a la base de datos
    mysqli_close($conn);

?>