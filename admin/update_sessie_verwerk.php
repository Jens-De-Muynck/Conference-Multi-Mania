<?php
    date_default_timezone_set('Europe/Brussels');
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require("../scripts/database.php");
    require("../scripts/functions.php");
    print("<pre>");
    print_r($_POST);
    print("</pre>");

    if(isset($_POST["submit"])==true){
        $stmt = $mysqli->prepare("UPDATE sessies SET titel=?, start=?, omschrijving=?, afbeelding=?, zaalID=?, sprekerID=? WHERE idsessie=?");

        if($mysqli->error!==""){
            print("<p>Error: ".$mysqli->error."</p>");
        }

        $stmt->bind_param("ssssiii", $title, $start, $omschrijving, $afbeelding, $zaalID, $sprekerID, $idsessie);

        $title = $_POST['title'];
        $start = $_POST['start'];
        $omschrijving = $_POST['omschrijving'];
        $afbeelding = get_tiny_url($_POST['afbeelding']);
        $zaalID = $_POST['zaal'];
        $sprekerID = $_POST['spreker'];
        $idsessie = $_POST['id'];

        $stmt->execute();
        //controleer op errors bij het uitvoeren van het statement

        if(count($stmt->error_list)){
            print("<pre>");
            print_r($stmt->error_list);
            print("</pre>");
        }
        $stmt->close();
        // print($stmt);
        header('location:sessies.php');
    }else{
        header('location:sessies.php');
    }
?>