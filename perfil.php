<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./utilities.js"></script>

    <title>Perfil</title>

</head>
<body id="bodyPerfil">
    <?php 
        include("./includes/header.php");
        include("utilidades.php");
    ?>
    <?php
        $conn = conectarBDD();

        $sqlQuery = "SELECT * FROM usuarios WHERE correo='".$_SESSION['correo']."';";
        $result = mysqli_query($conn, $sqlQuery);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_array($result);
            $usuario_id = $row['id'];
            $foto = $row['foto'];
            if(!$foto){
                $foto = "default.png";
            }
            $rutaImagenGuardada = "./perfiles/foto/".$foto;
            
        } else {
            echo "No existe este usuario.";
        }

    ?>
    <div class="datosPerfil">
        <div class="imagenPerfil">
            <form action="guardar_imagen.php" method="POST" enctype="multipart/form-data">
                <div class="contenedorFotoPerfil">
                    <img src=<?php echo "'".$rutaImagenGuardada."'"; ?> id="previewFotoPerfil" alt="Foto de perfil actual" class="FotoPerfil">
                    <label for="inpFotoPerfil" class="overlayFotoPerfil">
                        <span>Seleccionar imagen nueva</span>
                    </label>
                    <input type="file" id="inpFotoPerfil" name="foto_perfil" style="display:none;">
                </div>
                <input type="submit" value="Guardar" id="btnGuardar" style="display:none;">
            </form>
        </div>
        <div class="descripcionPerfil">
            
        </div>
    </div>

    <div class="gasolineras">
        <ul class="listagasolineras">
            <?php
                $sqlQuery = "select g.* from gasolineras g inner join favoritos_gasolinera fg on g.id = fg.gasolinera_id where fg.usuario_id =".$usuario_id;
                $result = mysqli_query($conn, $sqlQuery);

                if (mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $direccion = $row['Dirección'];
                        $latitud = $row['Latitud'];
                        $latitud = str_replace(',', '.', $latitud);
                        $localidad = $row['Localidad'];
                        $longitud = $row['Longitud__WGS84'];
                        $longitud = str_replace(',', '.', $longitud);
                        $provincia = $row['Provincia'];

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
                            '<form id="form_' . $row["id"] . '" action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form id="form_favorito_' . $row["id"] . '" method="post" onsubmit="return submitFormFavorito(' . $row["id"] . ');">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">' . $strFavorito . '
                            </form>' .
                            '<a href="https://www.google.com/maps?q='.urlencode($direccion . ', ' . $localidad . ', ' . $provincia).'&ll='.$latitud . ',' . $longitud.'&z=17" target="_blank">Ver ubicación</a>'.
                        "</li>";
                    }
                    
                    
                } else {
                    echo "No tiene ninguna gasolinera en favoritos.";
                }
            ?>
        </ul>
    </div>

    <script src="scripts.js"></script>
</body>
</html>
