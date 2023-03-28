<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gasolineras</title>
    <style>
        body {
            background-color: #add8e6;
            color: #0B3D91;
            font-family: Arial, sans-serif;
        }
        h1 {
            color: #0B3D91;
        }
        .gasolineras {
            margin: 20px;
            padding: 20px;
            background-color: white;
            border: 1px solid #0B3D91;
            border-radius: 5px;
        }
        .listagasolineras {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .listagasolineras li {
            margin: 5px 0;
            padding: 5px;
            background-color: #0B3D91;
            color: white;
            border-radius: 5px;
        }
        .listagasolineras li:nth-child(even) {
            background-color: #add8e6;
            color: #0B3D91;
        }
    </style>
</head>
<body>
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