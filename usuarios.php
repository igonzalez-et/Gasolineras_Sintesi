<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./utilities.js"></script>

	<title>Buscar usuarios</title>
</head>
<body id="bodyUsuarios">
    <?php 
        include("./includes/header.php");
    ?>
    <div class="contenedorBuscadorUsuario">
        <h1>Buscar usuarios</h1>
        <form id="buscadorUsuario">
            <input type="text" name="nombre" placeholder="Nombre">
            <button type="submit">Buscar</button>
        </form>
        <div id="resultado">
            <table>
                <?php 

                    if(isset($_SESSION['arrayRecientes']) && count($_SESSION['arrayRecientes']) > 0) {
                        echo "<tr><th>Búsquedas recientes</th></tr>";
                        
                        foreach ($_SESSION['arrayRecientes'] as $reciente) {
                            $sql2 = "SELECT * FROM usuarios WHERE nombre = '".$reciente."';";
                            $resultado2 = mysqli_query($conn, $sql2);
                        
                            if (mysqli_num_rows($resultado2) > 0) {
                                while ($row2 = mysqli_fetch_assoc($resultado2)) {
                                    if($reciente == $row2['nombre']) {
                                        $foto = $row2['foto'];
                                        if(!$foto){
                                            $foto = "default.png";
                                        }
                                        echo "<tr>";
                                        echo "<td><a href='../perfil.php?usuario=".$row2['nombre']."'><img src='./perfiles/foto/". $foto ."' alt='Foto de perfil de usuario'>" . $row2['nombre'] . "</a></td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                        }
                    }

                    // Cerrar la conexión a la base de datos
                    mysqli_close($conn);
                ?>
            </table>
        </div>
    </div>
	<script>
        // Buscador usuarios
        $(document).ready(function() {
            $('#buscadorUsuario').submit(function(event) {
                event.preventDefault();

                var datos = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: 'buscarUsuarios.php',
                    data: datos,
                    dataType: 'html',
                    success: function(resultado) {
                        $('#resultado').html(resultado);
                    }
                });
            });
        });
    </script>
    <script src="scripts.js"></script>
</body>
</html>