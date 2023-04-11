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
    <title>Gasolineras</title>
</head>
<body id="bodyGasolineras">
    <h1>Lista de gasolineras</h1>
    <div class="gasolineras">
        <ul class="listagasolineras">
            <?php
                // Conexión a la base de datos
                $servername = "localhost";
                $username = "igonzalez";
                $password = "Superlocal123";
                $dbname = "BGLC";

                $conn = mysqli_connect($servername, $username, $password, $dbname);

                // Verifica si se ha establecido la conexión
                if (!$conn) {
                    die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
                }

                if(isset($_SESSION["correo"])) {
                    $sql = "SELECT * FROM usuarios";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $usuario_id = $row["id"];
                        }
                    }
                }
                else {
                    echo "<script>alert('No has iniciado sesión')</script>";
                }

                // Consulta a la base de datos
                $sql = "SELECT * FROM gasolineras";
                $result = mysqli_query($conn, $sql);

                // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$row["id"].";";
                        $strFavorito = "";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2["contador"] == 0) {
                            $strFavorito = '<input type="submit" name="marcar_favorito" class="botonMarcar" value="Marcar Favorito">';
                        }else {
                            $strFavorito = '<input type="submit" name="marcar_favorito" class="botonMarcar favorito" value="Marcar Favorito">';
                        }
                        echo "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<form action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form method="post">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">'.$strFavorito.'
                                
                            </form>' .
                        "</li>";
                    }
                } else {
                    echo "No se encontraron resultados.";
                }

                if (isset($_POST['marcar_favorito'])) {
                    $id_gasolinera = $_POST['id_gasolinera'];
            
                    $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    if($row2["contador"] == 0) {
                        // Realiza la actualización en la base de datos para marcar la gasolinera como favorita
                        $sql = "INSERT INTO favoritos_gasolinera(usuario_id,gasolinera_id) VALUES(".$usuario_id.",".$id_gasolinera.")";
                        if (mysqli_query($conn, $sql)) {
                            echo "La gasolinera se ha marcado como favorita correctamente.";
                        } else {
                            echo "Error al marcar la gasolinera como favorita: " . mysqli_error($conn);
                        }
                    }else {
                        // Realiza la actualización en la base de datos para marcar la gasolinera como favorita
                        $sql = "delete from favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                        if (mysqli_query($conn, $sql)) {
                            echo "La gasolinera se ha eliminado como favorita correctamente.";
                        } else {
                            echo "Error al eliminar la gasolinera como favorita: " . mysqli_error($conn);
                        }
                    }


                    
                }


                // Cierra la conexión a la base de datos
                mysqli_close($conn);
            ?>
        </ul>
    </div>
</body>
</html>
