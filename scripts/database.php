<?php
    //Hier maken we verbinding met de db
    $mysqli = new mysqli('mysqlstudent','jensdemuynziem7i','AiCei3Aesh6K','jensdemuynziem7i');

    if ($mysqli->connect_errno) { 
        // In dit geval laat je de gebruiker best iets weten
        echo "Sorry, this website is experiencing problems."; 
        // Dit doe je best niet op een publieke website 
        echo "Error: Failed to make a MySQL connection, here is why: \n"; 
        echo "Errno: " . $mysqli->connect_errno . "\n"; 
        echo "Error: " . $mysqli->connect_error . "\n"; 
        // Je zou de gebruiker naar een mooie foutpagina kunnen brengen of gewoon stoppen 
        exit; 
    }
    else 
    { 
        echo '<script>';
        echo 'console.log("Verbinding gelukt!")';
        echo '</script>';

        $mysqli->set_charset('utf8');
    }
?>