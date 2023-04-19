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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./scripts.js"></script>
    
    <title>Gasolineras</title>
</head>
<body id="bodyGasolineras">
    <?php 
        include("./includes/header.php");
        include("utilidades.php");
    ?>
    <h1>Lista de gasolineras</h1>
    <div class="gasolineras">
        <ul class="listagasolineras">
            <?php
                $conn = conectarBDD();

                if(isset($_SESSION["correo"])) {
                    $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $usuario_id = $row["id"];
                        }
                    }
                }
                else {
                    echo "No has iniciado sesión";
                }

                // Consulta a la base de datos
                $sql = "SELECT * FROM gasolineras";
                $result = mysqli_query($conn, $sql);

                // Itera sobre los resultados de la consulta y agrega los datos a la lista HTML
                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$row["id"].";";
                        $strFavorito = "";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2["contador"] == 0) {
                            $strFavorito = '<input type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar" value="Marcar Favorito">';
                        }else {
                            $strFavorito = '<input type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonMarcar favorito" value="Marcar Favorito">';
                        }
                        echo 
                        "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<form id="form_' . $row["id"] . '" action="detalle_gasolinera.php" method="post" onsubmit="return submitForm(' . $row["id"] . ');">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form id="form_favorito_' . $row["id"] . '" method="post" onsubmit="return submitFormFavorito(' . $row["id"] . ');">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">' . $strFavorito . '
                            </form>' .
                        "</li>";
                    }
                } else {
                    echo "No se encontraron resultados.";
                }


                if (isset($_POST['funcion'])) {
                    $funcion = $_POST['funcion'];
                    
                    if ($funcion == 'marcarFavorito') {
                        $id_gasolinera = $_POST['id_gasolinera'];

                        $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                        $result2 = mysqli_query($conn, $sql2);
                        $row2 = mysqli_fetch_assoc($result2);
                        if($row2["contador"] == 0) {
                            $sql = "INSERT INTO favoritos_gasolinera(usuario_id,gasolinera_id) VALUES(".$usuario_id.",".$id_gasolinera.")";
                            if (mysqli_query($conn, $sql)) {
                                echo "<script>console.log('La gasolinera se ha marcado como favorita correctamente.');</script>";
                            } else {
                                echo "<script>console.log('Error al marcar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                            }
                        }else {
                            $sql = "delete from favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                            if (mysqli_query($conn, $sql)) {
                                echo "<script>console.log('La gasolinera se ha eliminado como favorita correctamente.');</script>";
                            } else {
                                echo "<script>console.log('Error al eliminar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                            }
                        }

                    } else {
                      echo 'Función no encontrada';
                    }
                }
                  


                function marcarFavorito() {
                    $id_gasolinera = $_POST['id_gasolinera'];
            
                    $sql2 = "SELECT count(*) as contador FROM favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                    $result2 = mysqli_query($conn, $sql2);
                    $row2 = mysqli_fetch_assoc($result2);
                    if($row2["contador"] == 0) {
                        // Realiza la actualización en la base de datos para marcar la gasolinera como favorita
                        $sql = "INSERT INTO favoritos_gasolinera(usuario_id,gasolinera_id) VALUES(".$usuario_id.",".$id_gasolinera.")";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>console.log('La gasolinera se ha marcado como favorita correctamente.');</script>";
                        } else {
                            echo "<script>console.log('Error al marcar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                        }
                    }else {
                        // Realiza la actualización en la base de datos para marcar la gasolinera como favorita
                        $sql = "delete from favoritos_gasolinera where usuario_id = ".$usuario_id." and gasolinera_id = ".$id_gasolinera.";";
                        if (mysqli_query($conn, $sql)) {
                            echo "<script>console.log('La gasolinera se ha eliminado como favorita correctamente.');</script>";
                        } else {
                            echo "<script>console.log('Error al eliminar la gasolinera como favorita: " . mysqli_error($conn). "');</script>";
                        }
                    }
                }
                


                // Cierra la conexión a la base de datos
                mysqli_close($conn);
            ?>
        </ul>
    </div>

<script>
    function submitForm(id) {
        event.preventDefault(); // Prevenir recarga de página
        var form = document.getElementById('form_' + id);
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.responseText) {
                console.log(xhr.responseText);
            } else {
                console.error('Error en la petición');
            }
        };
        xhr.send(formData);
        return false;
    }

    function submitFormFavorito(id) {
        event.preventDefault(); // Prevenir recarga de página
        var form = document.getElementById('form_favorito_' + id);
        var formData = new FormData(form);
        var xhr = new XMLHttpRequest();
        xhr.open('POST', form.action, true);
        xhr.onload = function () {
            if (xhr.status === 200 && xhr.responseText) {
                // console.log(xhr.responseText);
                console.log(id);
                var boton = $("#botonMarcar" + id);

                if (boton.hasClass('favorito')) {
                    boton.removeClass('favorito');
                } else {
                    boton.addClass('favorito');
                    llamarFuncionPHP(id);
                }
            } else {
                console.error('Error en la petición');
            }
        };
        xhr.send(formData);
        return false;
    }

    function llamarFuncionPHP(id_gasolinera) {
        $.ajax({
            url: "listado_gasolinera.php",
            type: "POST",
            data: { funcion: "marcarFavorito", id_gasolinera: id_gasolinera },
            success: function(respuesta) {
            console.log(respuesta);
            },
            error: function() {
            console.log("Error en la petición");
            }
        });
    }

</script>

</body>
</html>
