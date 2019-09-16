<?php
    date_default_timezone_set("Europe/Brussels");
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    include('../scripts/database.php');
    include('../scripts/functions.php');

    if (isset($_POST["submit"])) {

        // maak een statement en bind de variabelen
        $stmt = $mysqli->prepare("INSERT INTO `sessies`( `titel`, `start`, `omschrijving`, `afbeelding`, `zaalID`, `sprekerID`) VALUES (?,?,?,?,?,?)");

        if($mysqli->error){
            echo"<p>prepared statement failed: ".$mysqli->error."</p>";
            die;
        }

        // statement variabelen verbinden
        $stmt->bind_param("ssssii",$titel,$start,$omschrijving,$afbeelding,$zaalID,$sprekerID);

        // geef de variabelen een waarde
        $titel=$_POST['titel'];
        $start=$_POST['start'];
        $omschrijving=$_POST['omschrijving'];

        $afbeelding=$_POST['afbeelding'];
        if($afbeelding){
            // zie scripts/functions.php
            $afbeelding = get_tiny_url($afbeelding);
        }

        $zaalID=$_POST['zaal'];
        $sprekerID=$_POST['spreker'];

        // voer het statement uit
        $stmt->execute();

        // aantal toegevoede rijen bewaren voor foutafhandeling
        $affected_rows = $stmt->affected_rows;

        // uitgebreide foutafhandeling
        if(count($stmt->error_list)){
            print("<pre>");
            print_r($stmt->error_list);
            print("</pre>");
        }else{
            if($affected_rows>0){
                header("location: sessies.php");
            }else{
                echo "Did not insert any data.";
            }
        }

        // statement sluiten
        $stmt->close();
    }
?>