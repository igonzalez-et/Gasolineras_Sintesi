<?php 
    function conectarBDD(){
        $servername = "localhost";
        $username = "admin";
        $password = "admin123";
        $dbname = "BGLC";

        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Verificar conexión
        if (!$conn) {
            die("La conexión a la base de datos ha fallado: " . mysqli_connect_error());
        }
        return $conn;
    };
    
    function getListByQuery($query){
        $arrayQuestions = [];
        $pdo = conectarBDD();
        $stmt = $pdo -> prepare($query);            
        $stmt->execute();
        $row = $stmt->fetch();
        while($row){
            array_push($arrayQuestions, $row);
            $row = $stmt->fetch();
        }
        return $arrayQuestions;
    }

?>