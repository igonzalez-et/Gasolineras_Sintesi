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
                <li><button class="perfil" id="toggleButton"><i class="fa fa-user"></i> <?php echo "<span>".$_SESSION["correo"]."</span>" ?></button></li>
            </ul>
            <ul id="menu-perfil" class="hidden">
                <a href='./perfil.php'><li>Ver perfil</li></a>
                <a href='./logout.php'><li>Cerrar sesión</li></a>
            </ul>
        </nav>
    </div>
</header>
