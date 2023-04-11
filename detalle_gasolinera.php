
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle gasolinera</title>
</head>
<body>
    <div class="contenedorDetallesGasolinera">
        <?php
            if(!isset($_POST["id"])) {
                echo "No has seleccionado ninguna gasolinera.";
            }
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

            // Consulta a la base de datos
            $sql = "select * from gasolineras g left join precios_gasolinera pg on pg.gasolinera_id = g.id where g.id = ".$_POST["id"];
            $result = mysqli_query($conn, $sql);

            // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
            if (mysqli_num_rows($result) > 0) {
                while($row = mysqli_fetch_assoc($result)) {
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
    </div>
</body>
</html>
