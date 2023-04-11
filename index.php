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
    <title>Gasolineras</title>
</head>
<body>

    <div class="header">
        <div class="header-info">
            <?php
                echo "<span>".$_SESSION["correo"].", <a href='./login.php'>Cerrar sesión</a> </span>";
            ?>
        </div>
        <div class="nav-menu">
            <ul>
                <li>Inicio</li>
                <li>Gasolineras</li>
                <li>Calcular Gastos</li>
                <li>Contacto</li>
            </ul>
        </div>
    </div>

    <div class="slider">

    </div>

    <div class="contenedorPrincipal">
        
    </div>

    <div class="footer">

    </div>

</body>
</html>