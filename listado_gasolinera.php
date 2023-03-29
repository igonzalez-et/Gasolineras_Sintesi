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

                // Consulta a la base de datos
                $sql = "SELECT * FROM gasolineras";
                $result = mysqli_query($conn, $sql);

                // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        echo "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<form action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>' .
                        "</li>";
                    }
                } else {
                    echo "No se encontraron resultados.";
                }

                // Cierra la conexión a la base de datos
                mysqli_close($conn);
            ?>
        </ul>
    </div>

    
</body>
</html>