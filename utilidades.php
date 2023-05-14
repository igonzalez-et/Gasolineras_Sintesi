<?php 

    if(isset($_SESSION['success_message'])) {
        echo $_SESSION['success_message'];
        unset($_SESSION['success_message']);
    }

    if(isset($_SESSION['error_message'])) {
        echo $_SESSION['error_message'];
        unset($_SESSION['error_message']);
    }

    if(isset($_SESSION['warning_message'])) {
        echo $_SESSION['warning_message'];
        unset($_SESSION['warning_message']);
    }

    if(isset($_SESSION['info_message'])) {
        echo $_SESSION['info_message'];
        unset($_SESSION['info_message']);
    }


    function conectarBDD(){
        $servername = "localhost";
        $username = "igonzalez";
        $password = "Superlocal123";
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

    function showMessage($type, $text, $location) {
        $_SESSION[$type.'_message'] = '<div class="message '.$type.' show">
            <div class="message-icon">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <div class="message-text">
                <h3>'.ucfirst($type).'!</h3>
                <p>'.$text.'</p>
            </div>
        </div>';
        header('Location: '.$location);
        exit();
    }

?>