<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" type="text/css" href="styles.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://kit.fontawesome.com/700997539d.js" crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="./utilities.js"></script>
    <title>Calculadora de Gasolina</title>
</head>
<body id="bodyCalculadora">
    <?php 
        include("./includes/header.php");
    ?>
    <h1 class="titulosBody">Calculadora de Gasolina</h1>
    <form>
        <label for="precio-gasolina">Precio de la Gasolina:</label>
        <input type="number" id="precio-gasolina" name="precio-gasolina"><br>
        <label for="litros-gasolina">Litros de Gasolina:</label>
        <input type="number" id="litros-gasolina" name="litros-gasolina"><br>
        <input type="button" value="Calcular" onclick="calcularPrecio()"><br>
        <label for="precio-total">Precio Total:</label>
        <input type="number" id="precio-total" name="precio-total" disabled>
    </form>

    <script>
        function calcularPrecio() {
            var precioGasolina = document.getElementById("precio-gasolina").value;
            var litrosGasolina = document.getElementById("litros-gasolina").value;
            var precioTotal = precioGasolina * litrosGasolina;
            document.getElementById("precio-total").value = precioTotal;
        }
    </script>
</body>
</html>