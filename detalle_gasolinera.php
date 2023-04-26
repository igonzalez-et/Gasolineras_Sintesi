
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle gasolinera</title>
</head>
<body>
<?php
        include("utilidades.php");
        $conn = conectarBDD();
    ?>
    <div class="contenedorDetallesGasolinera">
        <?php
            if(!isset($_POST["id"])) {
                echo "No has seleccionado ninguna gasolinera.";
            }

            // Consulta a la base de datos
            $sql = "select * from gasolineras g left join precios_gasolinera pg on pg.gasolinera_id = g.id where g.id = ".$_POST["id"];
            $result = mysqli_query($conn, $sql);

            // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {

                    $direccion = $row['Dirección'];
                    $latitud = $row['Latitud'];
                    $latitud = str_replace(',', '.', $latitud);
                    $localidad = $row['Localidad'];
                    $longitud = $row['Longitud__WGS84'];
                    $longitud = str_replace(',', '.', $longitud);
                    $provincia = $row['Provincia'];

                    foreach ($row as $key) {
                        echo $key."<br>";
                    }
                }
            } else {
                echo "No se encontraron resultados.";
            }

            // Cierra la conexión a la base de datos
            mysqli_close($conn);
        ?>


       <iframe width="600" height="450" frameborder="0" style="border:0"
src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3107.622266178177!2d<?php echo $longitud; ?>!3d<?php echo $latitud; ?>!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xd620d8c08ab1b7f%3A0x244f0d93e16b1fb!2s<?php echo urlencode($direccion . ', ' . $localidad . ', ' . $provincia); ?>!5e0!3m2!1sen!2ses!4v1620195695186!5m2!1sen!2ses" allowfullscreen></iframe>



    </div>
</body>
</html>
