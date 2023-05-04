<header>
    <div class="header header-logo">
        <div class="logo logo-small"></div>
        <nav>
            <ul class="nav-menu nav-menu-logo">
                <li><a href="../">Inicio</a></li>
                <li><a href="../listado_gasolinera.php">Buscador de gasolineras</a></li>
                <li><a href="#">Calculadora de precios</a></li>
                <li><a href="#">Consejos para ahorrar</a></li>
                <li><a href="#">Preguntas frecuentes</a></li>
                <li><a href="../usuarios.php">Buscar Usuarios</a></li>
                <?php
                    include("utilidades.php");
                    $conn = conectarBDD();
                    if(isset($_SESSION["correo"])) {
                        $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $foto = $row['foto'];
                                if(!$foto){
                                    $foto = "default.png";
                                }
                                echo "<li><button class='perfil' id='toggleButton'><img src='./perfiles/foto/". $foto ."' alt='Foto de perfil de usuario'></button></li>";
                                echo "</ul>";
                                echo "<ul id='menu-perfil' class='hidden'>";
                                echo "<a href='./perfil.php?usuario=".$row['nombre']."'><li>Ver perfil</li></a>";
                                echo "<a href='./logout.php'><li>Cerrar sesión</li></a>";
                                echo "</ul>";
                            }
                        }
                    }
                    else {
                        echo "<li><button class='perfil' id='toggleButton'><i class='fa fa-user'></i></button></li>";
                        echo "</ul>";
                        echo "<ul id='menu-perfil' class='hidden'>";
                        echo "<a href='./login.php'><li>Iniciar Sesión</li></a>";
                        echo "</ul>";
                    }
                    
                ?>
            
        </nav>
    </div>
</header>
