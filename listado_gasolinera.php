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
    <script src="https://kit.fontawesome.com/700997539d.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./scripts.js"></script>
    <script src="./utilities.js"></script>

    
    <title>Gasolineras</title>
</head>

<body id="bodyGasolineras">
    <script>
        window.addEventListener('load', function() {
            document.getElementById('loader').style.display = 'none';
            document.getElementById('gasolineras').style.display = 'block';
        });
    </script>

    <div id="loader">
        <div class="loader-icon"></div>
        <div class="loader-text">Cargando...</div>
    </div>

    <?php 
        include("./includes/header.php");
        if(isset($_SESSION['correo'])){
            // if(isset($_SESSION['latitud']) && isset($_SESSION['longitud'])) {
            //     echo "LATITUD: ".$_SESSION['latitud']."<br>";
            //     echo "LONGITUD: ".$_SESSION['longitud'];
            // }
            
            include("./includes/listado.php");
        }
        else {
            include("./includes/no_sesion.php");
        }
    ?>
    
</body>
</html>
