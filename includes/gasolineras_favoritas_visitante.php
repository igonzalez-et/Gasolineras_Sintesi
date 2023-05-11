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
                            $strFavorito = '<button type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonFavoritoVisitante" value="Marcar Favorito"> <i class="fa fa-star-o"></i></button>';
                        }else {
                            $strFavorito = '<button type="submit" name="marcar_favorito" id="botonMarcar'.$row["id"].'" class="botonFavoritoVisitante favorito" value="Marcar Favorito"> <i class="fa fa-star"></i></button>';
                        }

                        echo 
                        "<li>CP: " . $row["CP"] . " - Dirección: " . $row["Dirección"] . " - Provincia: " . $row["Provincia"] . " - Rótulo: " . $row["Rótulo"] . " - Municipio: " . $row["Municipio"] .
                            '<div class="accionesGasolinera">'.
                            '<form id="form_' . $row["id"] . '" action="detalle_gasolinera.php" method="post">
                                <input type="hidden" name="id" value="' . $row["id"] . '">
                                <button type="submit">Ver detalles</button>
                            </form>
                            <form id="form_favorito_' . $row["id"] . '" method="post" onsubmit="return submitFormFavorito(' . $row["id"] . ');">
                                <input type="hidden" name="id_gasolinera" value="' . $row["id"] . '">' . $strFavorito . '
                            </form>' .
                            '<a href="https://www.google.com/maps?q='.urlencode($direccion . ', ' . $localidad . ', ' . $provincia).'&ll='.$latitud . ',' . $longitud.'&z=17" target="_blank">Ver ubicación</a>'.
                            '</div>'.
                        "</li>";
                    }
                    
                    
                } else {
                    echo "No tiene ninguna gasolinera en favoritos.";
                }
            ?>
        </ul>
    </div>