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
                <li><a href="#">Contacto</a></li>
                <?php
                    include("utilidades.php");
                    $conn = conectarBDD();
                    if(isset($_SESSION["correo"])) {
                        $sql = "SELECT * FROM usuarios where correo = '".$_SESSION["correo"]."';";
                        $result = mysqli_query($conn, $sql);
                        if (mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                echo "<li><button class='perfil' id='toggleButton'><img src='./perfiles/foto/". $row["foto"] ."' alt='Foto de perfil de usuario'> <span>".$_SESSION["correo"]."</span></button></li>";
                            }
                        }
                    }
                    else {
                        echo "<li><button class='perfil' id='toggleButton'><i class='fa fa-user'></i> <span>".$_SESSION["correo"]."</span></button></li>";
                    }
                    
                ?>
            </ul>
            <ul id="menu-perfil" class="hidden">
                <a href='./perfil.php'><li>Ver perfil</li></a>
                <a href='./logout.php'><li>Cerrar sesión</li></a>
            </ul>
        </nav>
    </div>
</header>
