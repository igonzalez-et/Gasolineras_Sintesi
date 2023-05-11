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
    ?>
    
    <div class="gasolineras">
        <h1>Lista de gasolineras</h1>

        <div class="filtros">
            <form method="GET">
                <div>
                    <label for="Rótulo">Rótulo:</label><br>
                    <select name="Rótulo">
                        <option value="Cualquiera">Cualquiera</option>
                        <?php
                            $sql = "select Rótulo from gasolineras group by Rótulo;";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if(isset($_GET["Rótulo"])) {
                                        if(strtoupper($_GET["Rótulo"]) == $row["Rótulo"]) {
                                            echo "<option value=\"$row[Rótulo]\" selected>$row[Rótulo]</option>\n";
                                        }
                                        else {
                                            echo "<option value=\"$row[Rótulo]\">$row[Rótulo]</option>\n";
                                        }
                                    }
                                    else {
                                        echo "<option value=\"$row[Rótulo]\">$row[Rótulo]</option>\n";
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="Provincia">Provincia:</label><br>
                    <select name="Provincia">
                        <option value="Cualquiera">Cualquiera</option>
                        <?php
                            $conn = conectarBDD();
                            $sql = "select Provincia from gasolineras group by Provincia;";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                while($row = mysqli_fetch_assoc($result)) {
                                    if(isset($_GET["Provincia"])) {
                                        if(strtoupper($_GET["Provincia"]) == $row["Provincia"]) {
                                            echo "<option value=\"$row[Provincia]\" selected>$row[Provincia]</option>\n";
                                        }
                                        else {
                                            echo "<option value=\"$row[Provincia]\">$row[Provincia]</option>\n";
                                        }
                                    }
                                    else {
                                        echo "<option value=\"$row[Provincia]\">$row[Provincia]</option>\n";
                                    }
                                }
                            }
                        ?>
                    </select>
                </div>
                <div>
                    <label for="Gasolina">Tipo de Gasolina:</label><br>
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
                                    if($row['columnas'] != 'gasolinera_id') {
                                        if(isset($_GET["Gasolina"])) {
                                            if(strtoupper($_GET["Gasolina"]) == strtoupper($row["columnas"])) {
                                                echo "<option value=\"$row[columnas]\" selected>$row[columnas]</option>\n";
                                            }
                                            else {
                                                echo "<option value=\"$row[columnas]\">$row[columnas]</option>\n";
                                            }
                                        }
                                        else {
                                            echo "<option value=\"$row[columnas]\">$row[columnas]</option>\n";
                                        }
                                    }
                                }
                            }
                        ?>
                    </select>
                </div><br>
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
                    "Rótulo" => isset($_GET["Rótulo"]) && $_GET["Rótulo"] !== "Cualquiera" ? $_GET["Rótulo"] : null,
                    "Provincia" => isset($_GET["Provincia"]) && $_GET["Provincia"] !== "Cualquiera" ? $_GET["Provincia"] : null,
                    // $_POST["Gasolina"] => isset($_POST["Gasolina"]) && $_POST["Gasolina"] !== "Cualquiera" ? $_POST["Gasolina"] : null,
                    "Campo2" => isset($_GET["Campo2"]) && $_GET["Campo2"] !== "Cualquiera" ? $_GET["Campo2"] : null,
                ];
                if(isset($_GET['Gasolina']) && $_GET['Gasolina'] != 'Cualquiera') {
                    $sql = "SELECT g.*, pg.".$_GET['Gasolina']." FROM gasolineras g INNER JOIN precios_gasolinera pg on g.id = pg.gasolinera_id ";
                }
                else {
                    $sql = "SELECT * FROM gasolineras ";
                }
                
                $condiciones = [];

                foreach ($filtros as $campo => $valor) {
                    if ($valor !== null) {
                        $condiciones[] = "$campo = '$valor'";
                    }
                }

                $condicionesBoolean = False;
                if (count($condiciones) > 0) {
                    $sql .= "WHERE ";
                    $sql .= implode(" AND ", $condiciones);
                    $condicionesBoolean = True;
                }

                if(isset($_GET["Gasolina"]) && $_GET['Gasolina'] != 'Cualquiera') {
                    if(!$condicionesBoolean) {
                        $sql .= "WHERE ";
                        $sql .= " pg.".$_GET['Gasolina'] ." != 'null' ";
                    }
                    else {
                        $sql .= " AND pg.".$_GET['Gasolina'] ." != 'null' ";
                    }
                    $sql .= "group by g.id, pg.".$_GET['Gasolina']." order by ".$_GET['Gasolina']." asc;" ;                
                }                
                echo '<script>console.log("'.$sql.'");</script>';

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
                            $strFavorito = '<button type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar" value="Marcar Favorito"> <i class="fa fa-star-o"></i></button>';
                        }else {
                            $strFavorito = '<button type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar favorito" value="Marcar Favorito"> <i class="fa fa-star"></i></button>';
                        }
                        echo 
                        "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<div class="accionesGasolinera">'.
                            '<form id="form_' . $row["id"] . '" action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form id="form_favorito_' . $row["id"] . '" method="post" onsubmit="return submitFormFavorito(' . $row["id"] . ');">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">' . $strFavorito . '
                            </form>' .
                            '<a href="https://www.google.com/maps?q='.urlencode($direccion . ', ' . $localidad . ', ' . $provincia).'&ll='.$latitud . ',' . $longitud.'&z=17" target="_blank">Ver ubicación</a>'.
                            '</div>'.
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
