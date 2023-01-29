<?php
if($_SERVER["REQUEST_METHOD"] == "POST"){
    include "includes/db.php";
    $table = $_POST["table"];

    if($table == "diabetes"){
        $pregunta1 = $_POST["pregunta1"];
        $pregunta2 = $_POST["pregunta2"];
        $pregunta3 = $_POST["pregunta3"];
        $pregunta4 = $_POST["pregunta4"];
        $pregunta5 = $_POST["pregunta5"];
        $pregunta6 = $_POST["pregunta6"];
        $pregunta7 = $_POST["pregunta7"];
        $pregunta8 = $_POST["pregunta8"];
        $pregunta9 = $_POST["pregunta9"];
        $pregunta10 = $_POST["pregunta10"];
        $pregunta11 = $_POST["pregunta11"];
        $pregunta12 = $_POST["pregunta12"];
        $pregunta13 = $_POST["pregunta13"];
        $pregunta14 = $_POST["pregunta14"];
        $pregunta15 = $_POST["pregunta15"];
        $pregunta16 = $_POST["pregunta16"];
        $pregunta17 = $_POST["pregunta17"];
        $pregunta18 = $_POST["pregunta18"];
        $pregunta19 = $_POST["pregunta19"];
        $pregunta20 = $_POST["pregunta20"];

        $stmt = $conn->prepare("INSERT INTO $table (pregunta1,pregunta2,pregunta3,pregunta4,pregunta5,pregunta6,pregunta7,pregunta8,pregunta9,pregunta10,pregunta11,pregunta12,pregunta13,pregunta14,pregunta15,pregunta16,pregunta17,pregunta18,pregunta19,pregunta20) VALUES (:pregunta1,:pregunta2,:pregunta3,:pregunta4,:pregunta5,:pregunta6,:pregunta7,:pregunta8,:pregunta9,:pregunta10,:pregunta11,:pregunta12,:pregunta13,:pregunta14,:pregunta15,:pregunta16,:pregunta17,:pregunta18,:pregunta19,:pregunta20)");

        $stmt->bindParam(':pregunta1', $pregunta1);
        $stmt->bindParam(':pregunta2', $pregunta2);
        $stmt->bindParam(':pregunta3', $pregunta3);
        $stmt->bindParam(':pregunta4', $pregunta4);
        $stmt->bindParam(':pregunta5', $pregunta5);
        $stmt->bindParam(':pregunta6', $pregunta6);
        $stmt->bindParam(':pregunta7', $pregunta7);
        $stmt->bindParam(':pregunta8', $pregunta8);
        $stmt->bindParam(':pregunta9', $pregunta9);
        $stmt->bindParam(':pregunta10', $pregunta10);
        $stmt->bindParam(':pregunta11', $pregunta11);
        $stmt->bindParam(':pregunta12', $pregunta12);
        $stmt->bindParam(':pregunta13', $pregunta13);
        $stmt->bindParam(':pregunta14', $pregunta14);
        $stmt->bindParam(':pregunta15', $pregunta15);
        $stmt->bindParam(':pregunta16', $pregunta16);
        $stmt->bindParam(':pregunta17', $pregunta17);
        $stmt->bindParam(':pregunta18', $pregunta18);
        $stmt->bindParam(':pregunta19', $pregunta19);
        $stmt->bindParam(':pregunta20', $pregunta20);

        $stmt->execute();

        header('Location: home.php');


        
    } 
}