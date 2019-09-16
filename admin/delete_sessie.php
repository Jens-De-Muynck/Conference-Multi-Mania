<?php

    date_default_timezone_set('Europe/Brussels');
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    require("../scripts/database.php");


    if(isset($_GET["id"])){
        $stmt = $mysqli->prepare("DELETE FROM sessies WHERE idsessie = ?");
        if($mysqli->error!==""){
            print("<p>Error: ".$mysqli->error."</p>");
        }
        $stmt->bind_param("i", $idsessie);

        $idsessie = $_GET['id'];

        $stmt->execute();
        //controleer op errors bij het uitvoeren van het statement
        if(count($stmt->error_list)){
            print("<pre>");
            print_r($stmt->error_list);
            print("</pre>");
        }
        $stmt->close();
        //print("gelukt");
        header("location:sessies.php");
    }else{
        print("error: u gaf geen querystring op");
    }

?>
