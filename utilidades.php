<?php 
    function conectarBDD(){
        try {
            $hostname = "localhost";
            $dbname = "BGLC";
            $username = "igonzalez";
            $pw = "Superlocal123";
            $pdo = new PDO ("mysql:host=$hostname;dbname=$dbname","$username","$pw");
            return $pdo;
        } catch (PDOException $e) {
            echo "Failed to get DB handle: " . $e->getMessage() . "\n";
            exit;
        }
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