<?php session_start(); ?>
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

    <title>Index</title>

</head>
<body id="bodyIndex">
    <header>
        <div class="header-fixed">
            <div class="logo"></div>
            <nav>
                <ul class="nav-menu">
                    <li><a href="../">Inicio</a></li>
                    <li><a href="../listado_gasolinera.php">Buscador de gasolineras</a></li>
                    <li><a href="../calculadora.php">Calculadora de precios</a></li>
                    <li><a href="../consejos.php">Consejos para ahorrar</a></li>
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
    <div class="section section1">
        <div class="wave-updown">
            <h2 class="border">BGLC</h2>
            <h2 class="wave">BGLC</h2>
        </div>
    </div>
    

    <div class="section section2">
        <div class="tarjeta tarjeta1 tarjeta-left">
            <h2>Buscador de gasolineras</h2>
            <hr>
            <div class="content">
                <div class="text">
                    <p>El buscador de gasolineras es una herramienta que permite a los usuarios encontrar estaciones de servicio cercanas a su ubicación o a una dirección específica que ingresen. El buscador utiliza información de geolocalización y bases de datos de estaciones de servicio para mostrar los resultados más precisos y relevantes para el usuario. Además, el buscador puede filtrar los resultados por tipo de combustible, horario de atención y otras características relevantes para el usuario.</p>
                    <p>En resumen, el buscador de gasolineras es una herramienta útil para cualquier persona que necesite encontrar una estación de servicio cercana y con los servicios que necesita.</p>
                    <p>Por otro lado, el buscador de gasolineras también puede ser beneficioso para los propietarios de estaciones de servicio. Al estar incluidos en la base de datos del buscador, tienen más posibilidades de ser encontrados por usuarios que podrían no haber conocido su existencia de otra manera. Esto puede llevar a un aumento en las ventas y a un aumento en la exposición de su marca. Además, si los propietarios de las estaciones de servicio tienen actualizada su información en la base de datos, los usuarios pueden tener una experiencia más satisfactoria al encontrar la información que necesitan de forma rápida y precisa.</p>
                </div>
                <img src="./img/buscador.jpg" class="image">
            </div>
            <div class="actButton">
                <a href="../listado_gasolinera.php">Buscar</a>
            </div>
        </div>
    </div>

    

    <div class="section section3">
        <div class="tarjeta tarjeta2 tarjeta-right">
            <br>
            <h2>Calculadora de precios</h2>
            <hr>
            <div class="content">
                <div class="text">
                    <p>Las calculadoras de precios de gasolina son herramientas útiles para ayudar a los conductores a estimar los costos de su viaje. Estas calculadoras funcionan al ingresar la cantidad de millas que se recorrerán y la eficiencia de combustible del vehículo. Luego, la calculadora utiliza el precio actual del combustible para estimar el costo total del viaje en gasolina. Algunas calculadoras también pueden proporcionar una comparación de precios entre diferentes estaciones de servicio cercanas.</p>
                    <p>Una de las ventajas de usar una calculadora de precios de gasolina es que puede ayudar a los conductores a planificar sus gastos de viaje y presupuestar adecuadamente para el combustible. Esto puede ser especialmente útil para aquellos que realizan viajes largos y necesitan saber cuánto dinero gastarán en gasolina. Además, al proporcionar información sobre las estaciones de servicio cercanas, las calculadoras pueden ayudar a los conductores a encontrar la mejor oferta en gasolina.</p>
                    <p>En resumen, las calculadoras de precios de gasolina son herramientas útiles para los conductores que desean planificar sus gastos de viaje y encontrar la mejor oferta en gasolina. Al utilizar la eficiencia de combustible del vehículo y el precio actual del combustible, estas calculadoras pueden proporcionar una estimación precisa del costo total del viaje en gasolina. Al hacer uso de estas herramientas, los conductores pueden ahorrar dinero y planificar de manera más efectiva sus viajes en automóvil.</p>
                </div>
                <img src="./img/calculadora.jpg" class="image">
            </div>
            <div class="actButton">
                <a href="../calculadora.php">Calcular</a>
            </div>
        </div>
    </div>

    <div class="section section4">
        <div class="tarjeta tarjeta3 tarjeta-left">
            <h2>Búsqueda de usuarios</h2>
            <hr>
            <div class="content">
                <div class="text">
                    <p>El buscador de usuarios es una herramienta que permite a los usuarios buscar a otros usuarios registrados en el sitio utilizando su nombre de usuario como criterio de búsqueda. Este buscador brinda a los usuarios la capacidad de encontrar rápidamente perfiles específicos y acceder a la información relacionada con esos usuarios.</p>
                    <p>Al utilizar el buscador de usuarios, los usuarios pueden ingresar el nombre de usuario de la persona que desean encontrar y realizar una búsqueda. El sistema buscará en la base de datos de usuarios registrados y mostrará los resultados que coincidan con el nombre de usuario proporcionado. Esto proporciona una forma conveniente y eficiente de localizar usuarios específicos en tu plataforma.</p>
                    <p>Una vez que un usuario encuentra el perfil de otro usuario, puede acceder a él para obtener más detalles e información. Dentro del perfil del usuario, se mostrará una sección dedicada a las gasolineras favoritas del usuario. Esta sección mostrará una lista de las gasolineras que el usuario ha marcado como favoritas en tu plataforma.</p>
                    <p>Esto ofrece una funcionalidad adicional para los usuarios, ya que les permite explorar y descubrir las preferencias de gasolineras de otros usuarios. Pueden ver las gasolineras favoritas de un usuario en particular, lo que puede ayudarles a encontrar recomendaciones y tomar decisiones informadas sobre qué gasolinera visitar.</p>
                </div>
                <img src="./img/usuarios.jpg" class="image">
            </div>
            <div class="actButton">
                <a href="../usuarios.php">Buscador</a>
            </div>
        </div>
    </div>
    <?php 
        include("includes/footer.php");
    ?>

    <script src="./scripts.js"></script>
</body>
</html>