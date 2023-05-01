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
    <script src="./scripts.js"></script>
    <script src="./utilities.js"></script>

    
    <title>Gasolineras</title>
</head>
<body id="bodyGasolineras">
    <?php 
        include("./includes/header.php");
        include("utilidades.php");
    ?>
    
    <div class="gasolineras">
        <h1>Lista de gasolineras</h1>

        <div class="filtros">
            <form method="POST">
                <label for="Rótulo">Rótulo:</label>
                <select name="Rótulo">
                    <option value="Cualquiera">Cualquiera</option>
                    <?php
                        $conn = conectarBDD();
                        $sql = "select Rótulo from gasolineras group by Rótulo;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"$row[Rótulo]\">$row[Rótulo]</option>\n";
                            }
                        }
                    ?>
                </select>
                <label for="Provincia">Provincia:</label>
                <select name="Provincia">
                    <option value="Cualquiera">Cualquiera</option>
                    <?php
                        $conn = conectarBDD();
                        $sql = "select Provincia from gasolineras group by Provincia;";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"$row[Provincia]\">$row[Provincia]</option>\n";
                            }
                        }
                    ?>
                </select>
                <label for="Gasolina">Tipo de Gasolina:</label>
                <select name="Gasolina">
                    <option value="Cualquiera">Cualquiera</option>
                    <?php
                        $conn = conectarBDD();
                        $sql = "SELECT COUNT(*) - 2 as contador FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'precios_gasolinera'";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $columnas = $row["contador"];
                            }
                        }
                        $sql = "select column_name as columnas FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'precios_gasolinera' limit ".$columnas.";";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<option value=\"$row[columnas]\">$row[columnas]</option>\n";
                            }
                        }
                    ?>
                </select>
                <input type="submit" value="Filtrar">
            </form>
        </div>
        
        <ul class="listagasolineras">
            <?php
                $conn = conectarBDD();

                if(isset($_SESSION["correo"])) {
                    $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $usuario_id = $row["id"];
                        }
                    }
                }
                else {
                    echo "No has iniciado sesión";
                }

                // Comprobar los filtros activos
                $filtros = [
                    "Rótulo" => isset($_POST["Rótulo"]) && $_POST["Rótulo"] !== "Cualquiera" ? $_POST["Rótulo"] : null,
                    "Provincia" => isset($_POST["Provincia"]) && $_POST["Provincia"] !== "Cualquiera" ? $_POST["Provincia"] : null,
                    // $_POST["Gasolina"] => isset($_POST["Gasolina"]) && $_POST["Gasolina"] !== "Cualquiera" ? $_POST["Gasolina"] : null,
                    "Campo2" => isset($_POST["Campo2"]) && $_POST["Campo2"] !== "Cualquiera" ? $_POST["Campo2"] : null,
                ];
                $sql = "SELECT * FROM gasolineras g INNER JOIN precios_gasolinera pg on g.id = pg.gasolinera_id WHERE ";
                $condiciones = [];

                foreach ($filtros as $campo => $valor) {
                    if ($valor !== null) {
                        $condiciones[] = "$campo = '$valor'";
                    }
                }

                if (count($condiciones) > 0) {
                    $sql .= implode(" AND ", $condiciones);
                } else {
                    $sql .= "1";
                }

                $result = mysqli_query($conn, $sql);

                if (mysqli_num_rows($result) > 0) {
                    
                    while($row = mysqli_fetch_assoc($result)) {
                        $direccion = $row['Dirección'];
                        $latitud = $row['Latitud'];
                        $latitud = str_replace(',', '.', $latitud);
                        $localidad = $row['Localidad'];
                        $longitud = $row['Longitud__WGS84'];
                        $longitud = str_replace(',', '.', $longitud);
                        $provincia = $row['Provincia'];

                        $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$row["id"].";";
                        $strFavorito = "";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2["contador"] == 0) {
                            $strFavorito = '<input type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar" value="Marcar Favorito">';
                        }else {
                            $strFavorito = '<input type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar favorito" value="Marcar Favorito">';
                        }
                        echo 
                        "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<form id="form_' . $row["id"] . '" action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form id="form_favorito_' . $row["id"] . '" method="post" onsubmit="return submitFormFavorito(' . $row["id"] . ');">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">' . $strFavorito . '
                            </form>' .
                            '<a href="https://www.google.com/maps?q='.urlencode($direccion . ', ' . $localidad . ', ' . $provincia).'&ll='.$latitud . ',' . $longitud.'&z=17" target="_blank">Ver ubicación</a>'.
                        "</li>";
                    }
                } else {
                    echo "No se encontraron resultados.";
                }


                if (isset($_POST['funcion'])) {
                    $funcion = $_POST['funcion'];
                    
                    if ($funcion == 'marcarFavorito') {
                        $id_gasolinera = $_POST['id_gasolinera'];

                        $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2["contador"] == 0) {
                            $sql = "INSERT INTO favoritos_gasolinera(usuario_id,gasolinera_id) VALUES(".$usuario_id.",".$id_gasolinera.")";
                            if (mysqli_query($conn, $sql)) {
                                echo "<script>console.log('La gasolinera se ha marcado como favorita correctamente.');</script>";
                            } else {
                                echo "<script>console.log('Error al marcar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                            }
                        }else {
                            $sql = "delete from favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                            if (mysqli_query($conn, $sql)) {
                                echo "<script>console.log('La gasolinera se ha eliminado como favorita correctamente.');</script>";
                            } else {
                                echo "<script>console.log('Error al eliminar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                            }
                        }

                    }else {
                      echo 'Función no encontrada';
                    }
                }

                // Cierra la conexión a la base de datos
                mysqli_close($conn);
            ?>
        </ul>
    </div>

</body>
</html>
