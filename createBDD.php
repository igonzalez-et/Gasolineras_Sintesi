<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Base de datos gasolineras</title>
</head>
<body>
    <?php
        include("utilidades.php");
        $conn = conectarBDD();
        set_time_limit(300);

    ?>
    <?php
        $url = "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/";
        $data = file_get_contents($url);
        $json = json_decode($data, true);

        $arrayKeys = array();
        foreach ($json['ListaEESSPrecio'] as $gasolinera) {
            $gasolineraLog = $gasolinera;
            $arrayKeys = array_keys($gasolineraLog);
        }

        // Crea la tabla
        $sqlDrop = "DROP TABLE IF EXISTS gasolineras";
        $sqlDrop2 = "DROP TABLE IF EXISTS precios_gasolinera";
        $sqlDrop3 = "DROP TABLE IF EXISTS favoritos_gasolinera";
        $sqlDrop4 = "DROP TABLE IF EXISTS mensajes_usuarios";
        $sqlDrop5 = "DROP TABLE IF EXISTS mensajes;";
        $sqlDrop6 = "DROP TABLE IF EXISTS usuarios;";

        if (mysqli_query($conn, $sqlDrop4)) {
            echo "La tabla mensajes_usuarios ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        if (mysqli_query($conn, $sqlDrop3)) {
            echo "La tabla favoritos_gasolinera ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }
          
        if (mysqli_query($conn, $sqlDrop2)) {
            echo "La tabla precios_gasolinera ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        if (mysqli_query($conn, $sqlDrop5)) {
            echo "La tabla mensajes ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        if (mysqli_query($conn, $sqlDrop6)) {
            echo "La tabla usuarios ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        if (mysqli_query($conn, $sqlDrop)) {
            echo "La tabla gasolineras ha sido eliminada correctamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }
        

        

        $sql = "CREATE TABLE gasolineras (id INT(20) AUTO_INCREMENT PRIMARY KEY";
        $sqlPrecio = "CREATE TABLE precios_gasolinera (";
        foreach ($arrayKeys as $key) {
            $key = str_replace(' ', '_', $key);
            $key = str_replace('%', '', $key);
            $key = str_replace('.', '', $key);
            $key = str_replace('(', '_', $key);
            $key = str_replace(')', '', $key);

            $subs = substr($key,0,6);
            if ($subs === "Precio") {
                $sqlPrecio .= $key . " VARCHAR(20), ";
            }else {
                $sql .= ", " . $key . " VARCHAR(200)";
            }
        }
        $sql .= ")";

        if ($sqlPrecio !== "CREATE TABLE precios_gasolinera (") {
            $sqlPrecio .= "gasolinera_id INT(100) , ultima_actualizacion DATETIME, FOREIGN KEY (gasolinera_id) REFERENCES gasolineras(id))";
        }

        if (mysqli_query($conn, $sql)) {
            echo "La tabla gasolineras ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }
        echo $sql;
        echo $sqlPrecio;
        if (mysqli_query($conn, $sqlPrecio)) {
            echo "La tabla precios_gasolinera ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        $sqlUsuarios = "CREATE TABLE `usuarios` (
            `id` int NOT NULL AUTO_INCREMENT,
            `nombre` varchar(255) NOT NULL,
            `correo` varchar(255) NOT NULL,
            `contraseña` varchar(255) NOT NULL,
            `foto` varchar(255) DEFAULT 'default.png',
            `privacidad` varchar(7) DEFAULT 'publico',
            PRIMARY KEY (`id`),
            UNIQUE KEY `unique_nombre` (`nombre`),
            UNIQUE KEY `unique_correo` (`correo`)
        )";

        echo $sqlUsuarios;
        if (mysqli_query($conn, $sqlUsuarios)) {
            echo "La tabla usuarios ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        $sqlMensajes = "create table `mensajes` (
            `id` int NOT NULL AUTO_INCREMENT,
            `mensaje` varchar(512) NOT NULL,
            `fecha` DATETIME NOT NULL,
            PRIMARY KEY (`id`)
        )";

        echo $sqlMensajes;
        if (mysqli_query($conn, $sqlMensajes)) {
            echo "La tabla mensajes ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        $sqlMensajesUsuarios = "create table `mensajes_usuarios` (
            `usuario_id` int DEFAULT NULL,
            `gasolinera_id` int DEFAULT NULL,
            `mensaje_id` int DEFAULT NULL,
             KEY `usuario_id` (`usuario_id`),
             KEY `gasolinera_id` (`gasolinera_id`),
             KEY `mensaje_id` (`mensaje_id`),
             CONSTRAINT `mensajes_usuarios_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
             CONSTRAINT `mensajes_usuarios_ibfk_2` FOREIGN KEY (`gasolinera_id`) REFERENCES `gasolineras` (`id`),
             CONSTRAINT `mensajes_usuarios_ibfk_3` FOREIGN KEY (`mensaje_id`) REFERENCES `mensajes` (`id`)
        )";

        echo $sqlMensajesUsuarios;
        if (mysqli_query($conn, $sqlMensajesUsuarios)) {
            echo "La tabla mensajes_usuarios ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }

        $sqlFavoritos = "CREATE TABLE `favoritos_gasolinera` (
            `usuario_id` int DEFAULT NULL,
            `gasolinera_id` int DEFAULT NULL,
            KEY `usuario_id` (`usuario_id`),
            KEY `gasolinera_id` (`gasolinera_id`),
            CONSTRAINT `favoritos_gasolinera_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuarios` (`id`),
            CONSTRAINT `favoritos_gasolinera_ibfk_2` FOREIGN KEY (`gasolinera_id`) REFERENCES `gasolineras` (`id`)
          )";

        echo $sqlFavoritos;
        if (mysqli_query($conn, $sqlFavoritos)) {
            echo "La tabla favoritos_gasolinera ha sido creada exitosamente";
        } else {
            echo "Error al crear la tabla: " . mysqli_error($conn);
        }



        // Recorremos los datos de la API
        foreach ($json['ListaEESSPrecio'] as $gasolinera) {
            $stringTotal = "";
            $stringTotalPrecio = "";
            foreach ($gasolinera as $key => $datos) {
                $subs = substr($key,0,6);

                if($subs == "Precio"){
                    if($datos != ""){
                        $stringTotalPrecio .= "'" . mysqli_real_escape_string($conn, $datos) . "',";
                    }
                    else {
                        $stringTotalPrecio .= "NULL,";
                    }
                }
                else{
                    $stringTotal .= "'" . mysqli_real_escape_string($conn, $datos) . "',";
                }

            }
            $stringTotal = substr($stringTotal, 0, -1);
            $stringTotalPrecio = substr($stringTotalPrecio, 0, -1);

            $stringColumns = "";
            $stringColumnsPrecio = "";
            foreach ($arrayKeys as $key) {
                $key = str_replace(' ', '_', $key);
                $key = str_replace('%', '', $key);
                $key = str_replace('.', '', $key);
                $key = str_replace('(', '_', $key);
                $key = str_replace(')', '', $key);

                $subs = substr($key,0,6);

                if ($subs === "Precio") { 
                    $stringColumnsPrecio .= $key . ",";
                } else {
                    $stringColumns .= $key . ",";
                }
            }
            $stringColumns = substr($stringColumns, 0, -1);
            $stringColumnsPrecio = substr($stringColumnsPrecio, 0, -1);
        
            // Insertamos los datos dentro de la tabla gasolineras
            $sqlQuery = "INSERT INTO gasolineras(".$stringColumns.") VALUES(".$stringTotal.");";
            
             if (mysqli_query($conn, $sqlQuery)) {
                 echo "Los datos se han insertado correctamente";
             } else {
                echo "Error: " . $sqlQuery . "<br>" . mysqli_error($conn);
             }

            // Insertamos los datos dentro de la tabla gasolineras

            // Consulta a la base de datos
            $sqlQuery = "SELECT * FROM gasolineras";
            $result = mysqli_query($conn, $sqlQuery);

            // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
                    $sqlQuery2 = "INSERT INTO precios_gasolinera(".$stringColumnsPrecio.",gasolinera_id,ultima_actualizacion) VALUES(".$stringTotalPrecio.",".$row['id'].",current_timestamp());";
                }
                if (mysqli_query($conn, $sqlQuery2)) {
                    echo $sqlQuery2;
                } else {
                    echo "Error: " . $sqlQuery2 . "<br>" . mysqli_error($conn);
                }
            } else {
                echo "No se encontraron resultados.";
            }            
        }

        // Cierra la conexión
        mysqli_close($conn);
    ?>

</body>
</html>