<?php
date_default_timezone_set("Europe/Brussels");
error_reporting(E_ALL);
ini_set('display_errors', 'On');

    // Connectie met DB
    require_once("scripts/database.php");

    if(isset($_GET["idsprekers"])){

        $stmt = $mysqli->prepare("UPDATE sessies SET likecounter = likecounter + 1 WHERE sprekerID=?");
        
        $stmt->bind_param('i', $sprekerID);
        $sprekerID = $_GET["idsprekers"];

        $stmt->execute();

        $stmt->close();
    }

    header("Location: {$_SERVER['HTTP_REFERER']}");
?>