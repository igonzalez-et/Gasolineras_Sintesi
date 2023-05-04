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
    <title>Detalle gasolinera</title>
</head>
<body id="bodyDetalleGasolineras">
<?php
        include("./includes/header.php");
        if(isset($_SESSION["correo"])) {
            $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
            $result = mysqli_query($conn, $sql);
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $usuario_id = $row["id"];
                }
            }
        }
    ?>
    <div class="contenedorDetallesGasolinera">
        <?php
            if(isset($_POST['id'])) {
                $_SESSION["gasolinera"] = $_POST["id"];
            }

            // Consulta a la base de datos
            $sql = "select * from gasolineras g left join precios_gasolinera pg on pg.gasolinera_id = g.id where g.id = ". $_SESSION["gasolinera"] ." order by ultima_actualizacion desc limit 1";
            $result = mysqli_query($conn, $sql);

            // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<div class='generalGasolinera'>";
                    echo "<div class='informacionGasolinera'>";
                    echo "<h2>Información:</h2>";

                    $cp = $row['CP'];
                    $direccion = $row['Dirección'];
                    $horario = $row['Horario'];
                    $localidad = $row['Localidad'];
                    $municipio = $row['Municipio'];
                    $provincia = $row['Provincia'];
                    $rotulo = $row['Rótulo'];
                    $ultima_actualizacion = $row['ultima_actualizacion'];


                    // Hacer reemplazos en el horario
                    $horario = str_replace("-", " a ", $horario);
                    $horario = str_replace(";", "<br>", $horario);

                    if (strpos($horario, "L") !== false) {
                        $horario = str_replace("L", "Lunes", $horario);
                    }
                    if (strpos($horario, "J") !== false) {
                        $horario = str_replace("J", "Jueves", $horario);
                    }
                    if (strpos($horario, "V") !== false) {
                        $horario = str_replace("V", "Viernes", $horario);
                    }
                    if (strpos($horario, "S") !== false) {
                        $horario = str_replace("S", "Sábado", $horario);
                    }
                    if (strpos($horario, "D") !== false) {
                        $horario = str_replace("D", "Domingo", $horario);
                    }
                    

                    echo "<p>Código Postal: ". $cp ."</p>";
                    echo "<p>Provincia: ". $provincia . "</p>";
                    echo "<p>Municipio: ". $municipio . "</p>";
                    echo "<p>Direccion: ". $direccion . "</p>";
                    echo "<p>Localidad: ". $localidad . "</p>";
                    echo "<p>Rótulo: ". $rotulo . "</p>";
                    
                    //Recoger la ubicación para utilizarlo en el maps 
                    $latitud = $row['Latitud'];
                    $latitud = str_replace(',', '.', $latitud);
                    $longitud = $row['Longitud__WGS84'];
                    $longitud = str_replace(',', '.', $longitud);
                    
                    echo "</div>";

                    echo "<div class='preciosGasolinera'>";
                    echo "<h2>Precios:</h2>";
                    foreach ($row as $key => $value) {
                        if (strpos($key, "Precio") === 0) {
                            if($value != null || $value != "") {
                                $key = str_replace("Precio_", "", $key);
                                echo "<p>$key $value €</p>";
                            }
                        }
                    }

                    echo "</div>";

                    echo "<div class='contenedorHorario'>";
                    echo "<p><b>Horario:</b><br> ". $horario . "</p>";    
                    echo "</div>";

                    echo "<p class='pUltimaActualizacion'><b>Ultima actualización</b>: ". $ultima_actualizacion . "</p>";

                    echo "</div>";
                }
            } else {
                echo "No se encontraron resultados.";
            }

            
        ?>
        <div class="contenedorRutaDetalles">
            <iframe id="mapaDetalles" frameborder="0" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3107.622266178177!2d<?php echo $longitud; ?>!3d<?php echo $latitud; ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd620d8c08ab1b7f%3A0x244f0d93e16b1fb!2s<?php echo urlencode($direccion . ', ' . $localidad . ', ' . $provincia); ?>!5e0!3m2!1sen!2ses!4v1620195695186!5m2!1sen!2ses" allowfullscreen></iframe>
            
            <?php
                echo '<a href="https://www.google.com/maps?q='.urlencode($direccion . ', ' . $localidad . ', ' . $provincia).'&ll='.$latitud . ',' . $longitud.'&z=17" target="_blank">Ver ubicación</a>';
            ?>
        </div>
    </div>
    <div class="contenedorMensajes">
        <h2>Comentarios: </h2><br>
        <form method="post">
            <label for="mensaje">Ingrese su mensaje (máximo 512 caracteres):</label><br>
            <textarea id="mensajeUsuario" name="mensaje" maxlength="512"></textarea><br>
            <input id="enviarComentario" type="submit" value="Enviar comentario">
        </form>
        <div class="user-comment">
            <?php
                $sql3 = "SELECT count(*) as contador FROM mensajes;";
                $result3 = mysqli_query($conn, $sql3);
                if (mysqli_num_rows($result3) > 0) {
                    while($row3 = mysqli_fetch_assoc($result3)) {
                        if($row3["contador"] > 0) {
                            if(isset($_SESSION["gasolinera"])) {
                                $sql = "select * from mensajes m inner join mensajes_usuarios mu on m.id = mu.mensaje_id where gasolinera_id = ".$_SESSION["gasolinera"].";";
                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) {
                                    while($row = mysqli_fetch_assoc($result)) {
                                        $usuario = $row["usuario_id"];
                                        $sql2 = "SELECT * FROM usuarios where id = ".$usuario.";";
                                        $result2 = mysqli_query($conn, $sql2);
                                        if (mysqli_num_rows($result2) > 0) {
                                            while($row2 = mysqli_fetch_assoc($result2)) {
                                                $mostrarMensaje = "<p class='user-name'><img src='./perfiles/foto/". $row2["foto"] ."' alt='Foto de perfil de usuario'> ". $row2["nombre"] . " - " ;
                                            }
                                        }
        
                                        // Definir la fecha y hora del comentario
                                        $fecha_comentario = $row["fecha"];
                                        $timestamp_comentario = strtotime($fecha_comentario);
                                        $timestamp_actual = time();
                                        $diferencia_segundos = $timestamp_actual - $timestamp_comentario;
        
                                        // Calcular la cantidad de tiempo de diferencia
                                        if ($diferencia_segundos < 60) {
                                            $tiempo_relativo = "Hace unos segundos";
                                        } elseif ($diferencia_segundos < 3600) {
                                            $cantidad = floor($diferencia_segundos / 60);
                                            $tiempo_relativo = "Hace " . $cantidad . " minutos";
                                        } elseif ($diferencia_segundos < 86400) {
                                            $cantidad = floor($diferencia_segundos / 3600);
                                            $tiempo_relativo = "Hace " . $cantidad . " horas";
                                        } elseif ($diferencia_segundos < 604800) {
                                            $cantidad = floor($diferencia_segundos / 86400);
                                            $tiempo_relativo = "Hace " . $cantidad . " días";
                                        } elseif ($diferencia_segundos < 2592000) {
                                            $cantidad = floor($diferencia_segundos / 604800);
                                            $tiempo_relativo = "Hace " . $cantidad . " semanas";
                                        } elseif ($diferencia_segundos < 31536000) {
                                            $cantidad = floor($diferencia_segundos / 2592000);
                                            $tiempo_relativo = "Hace " . $cantidad . " meses";
                                        } else {
                                            $cantidad = floor($diferencia_segundos / 31536000);
                                            $tiempo_relativo = "Hace " . $cantidad . " años";
                                        }
        
                                        $mostrarMensaje .= $tiempo_relativo . "</p><p class='comment-text'>" . $row["mensaje"]."</p> <br>";
                                        echo $mostrarMensaje;
                                    }
                                }
                            }
                        }
                    }
                }

                
            ?>
        </div>
    </div>

    <?php
        if(isset($_POST["mensaje"]) && !empty($_POST["mensaje"])) {
            $mensaje = $_POST["mensaje"];

            $sql = "INSERT INTO mensajes(mensaje, fecha) VALUES('".$mensaje."', current_timestamp())";
            if (mysqli_query($conn, $sql)) {
                echo "<script>console.log('El mensaje se ha guardado correctamente.');</script>";
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
                    echo "<script>console.log('El mensajes_usuarios se ha guardado correctamente.');</script>";
                }
                else {
                    echo "<script>console.log('Error al guardar el mensajes_usuarios: " . mysqli_error($conn). "');</script>";
                }


            } else {
                echo "<script>console.log('Error al guardar el mensaje: " . mysqli_error($conn). "');</script>";
            }

        }
        mysqli_close($conn);
    ?>
</body>
</html>
