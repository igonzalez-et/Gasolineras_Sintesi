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
        // Recorremos los datos de la API
        foreach ($json['ListaEESSPrecio'] as $gasolinera) {
            

            // Consulta a la base de datos
            $sqlQuery = "SELECT * FROM gasolineras";
            $result = mysqli_query($conn, $sqlQuery);

            // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
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
                    }
                    $stringTotalPrecio = substr($stringTotalPrecio, 0, -1);
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
                        }
                    }
                    $stringColumnsPrecio = substr($stringColumnsPrecio, 0, -1);
                    $sqlQuery2 = "INSERT INTO precios_gasolinera(".$stringColumnsPrecio.",gasolinera_id,ultima_actualizacion) VALUES(".$stringTotalPrecio.",".$row['id'].",current_timestamp());";
                    if (mysqli_query($conn, $sqlQuery2)) {
                        echo $sqlQuery2;
                    } else {
                        echo "Error: " . $sqlQuery2 . "<br>" . mysqli_error($conn);
                    }
                }        
            }
        }
        // Cierra la conexión
        mysqli_close($conn);
    ?>
