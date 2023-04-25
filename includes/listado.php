<php

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

?>