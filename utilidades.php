<?php 
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