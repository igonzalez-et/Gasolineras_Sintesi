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