<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "includes/db.php";
    $table = $_POST["table"];

    if($table != "administrators"){
       
        foreach ($_POST as $column => $value){
            if($column == "table"){
                continue;
            }

            $stmt = $conn->prepare("INSERT INTO $table ($column) VALUES (:To_insert)");
            $stmt->bindParam(':To_insert', $value);
        }
        $stmt->execute();
    
    }    

    header('Location: home.php');

}