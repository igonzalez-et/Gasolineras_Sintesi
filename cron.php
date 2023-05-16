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
            set_time_limit(300);
            include("utilidades.php");
            $conn = conectarBDD();

            $url = "https://sedeaplicaciones.minetur.gob.es/ServiciosRESTCarburantes/PreciosCarburantes/EstacionesTerrestres/";
            $data = file_get_contents($url);
            $json = json_decode($data, true);

            $arrayKeys = array();
            foreach ($json['ListaEESSPrecio'] as $gasolinera) {
                $gasolineraLog = $gasolinera;
                $arrayKeys = array_keys($gasolineraLog);
            }

            $countGasolinera = 0;
            foreach ($json['ListaEESSPrecio'] as $gasolinera) {
                $countGasolinera += 1;
                $stringTotalPrecio = "";
                foreach ($gasolinera as $key => $datos) {       
                    if($key == "Dirección") {
                        $direccion = $datos;
                    }
                    
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
                // echo $direccion."<br>";
                // Consulta a la base de datos
                $direccion_escapada = mysqli_real_escape_string($conn, $direccion);
                $sqlQuery = "SELECT *, count(*) as existe FROM gasolineras where Dirección = '".$direccion_escapada."';";
                $result = mysqli_query($conn, $sqlQuery);

                // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        if($row['existe'] != 0) {
                            $sqlQuery2 = "INSERT INTO precios_gasolinera(".$stringColumnsPrecio.",gasolinera_id,ultima_actualizacion) VALUES(".$stringTotalPrecio.",".$row['id'].",current_timestamp());";
                        }
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

