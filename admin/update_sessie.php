<?php
    date_default_timezone_set("Europe/Brussels");
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    include('../scripts/database.php');

    // get current session data
    if (isset($_GET["id"]) ? $id = $_GET["id"] : header("Location: {$_SERVER['HTTP_REFERER']}")) {

            $stmt = $mysqli->prepare("SELECT * FROM sessies WHERE idsessie = ?");
            $stmt->bind_param("i", $_GET['id']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) exit('Could not find this session in the database');
            while($row = $result->fetch_assoc()) {
                $titel = $row['titel'];
                $start = $row['start'];
                $omschrijving = $row['omschrijving'];
                $afbeelding = $row['afbeelding'];
                $zaalid = $row['zaalID'];
                $sprekerid = $row['sprekerID'];

            }
            $stmt->close();
    }

    // get rooms and speakers
    $sqlZalen = "SELECT * FROM zalen";
    if (!$resultZalen = $mysqli->query($sqlZalen)) {
        echo "Sorry, the website could not fetch the rooms where sessions are given.";
        exit;
    }

    $sqlSprekers = "SELECT * FROM sprekers";
    if (!$resultSprekers = $mysqli->query($sqlSprekers)) {
        echo "Sorry, the website could not fetch the speakers that are present.";
        exit;
    }
?>

<!doctype html>
<html lang="en">

<head>
<title>MM - Edit Session</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Custom CSS-->
<link rel="stylesheet" href="../style/style.css" type="text/css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
    integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
</head>

<body>

<!-- Start Nav -->
<header>
    <!-- Small Nav -->
    <div class="smallnav pos-f-t fixed-top">
        <div class="collapse" id="navbarToggleExternalContent">
            <div>
                <ul class="navbar-nav m-auto mt-2 mt-lg-0 bold">
                    <li class="nav-item align-middle">
                        <a class="nav-link" href="../index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../overzicht_spreker.php?p=1">SPEAKERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../overzicht_zalen.php">SCHEDULE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SPONSORS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="sessies.php">TICKETS</a>
                    </li>
                </ul>
            </div>
        </div>
        <nav class="navbar navbar-dark float-right">
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarToggleExternalContent" aria-controls="navbarToggleExternalContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
            </button>
        </nav>
    </div>

    <!-- Big Nav -->
    <nav class="bignav navbar navbar-expand-lg fixed-top bg-transparent">
        <a class="navbar-brand" href="#">
            <img src="../images/logo.svg" width="350" class="d-inline-block align-center" alt="">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
            aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0 bold">
                <li class="nav-item">
                    <a class="nav-link" href="../index.php">HOME</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../overzicht_spreker.php?p=1">SPEAKERS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../overzicht_zalen.php">SCHEDULE</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#">SPONSORS</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="sessies.php">TICKETS</a>
                </li>
            </ul>
            <div class="input-group">
                <input type="text" class="form-control" placeholder="Search">
                <div class="input-group-append">
                    <button class="btn" type="button">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
            </div>
        </div>
    </nav>
</header>

<main class="admin">
    <section class="container">
        <h1>Edit session</h1>
        <h3><a href='sessies.php'>Back to overview</a></h3>
        <form method="post" action="update_sessie_verwerk.php">
            <div class="form-group">
                <label for="id">ID</label>
                <input type="text" class="form-control" name="id" readonly value="<?php print($id)?>">
            </div>

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" class="form-control" name="title" placeholder="<?php echo $titel ?>">
            </div>
            <div class="form-group">
                <label for="start">Start</label>
                <select name="start">
                    <option <?php echo ($start == "10:30") ? "selected": ""; ?> value="10:30">10:30</option>
                    <option <?php echo ($start == "11:30") ? "selected": ""; ?> value="11:30">11:30</option>
                    <option <?php echo ($start == "12:30") ? "selected": ""; ?> value="12:30">12:30</option>
                    <option <?php echo ($start == "14:00") ? "selected": ""; ?> value="14:00">14:00</option>
                    <option <?php echo ($start == "15:00") ? "selected": ""; ?> value="15:00">15:00</option>
                    <option <?php echo ($start == "16:00") ? "selected": ""; ?> value="16:00">16:00</option>
                    <option <?php echo ($start == "17:00") ? "selected": ""; ?> value="17:00">17:00</option>
                </select>
            </div>
            <div class="form-group">
                <label for="omschrijving">Description</label>
                <textarea type="text" class="form-control" name="omschrijving" placeholder="<?php echo $omschrijving; ?>"></textarea>
            </div>
            <div class="form-group">
                <label for="afbeelding">Image</label>
                <input type="text" class="form-control" name="afbeelding" placeholder="<?php echo $afbeelding; ?>">
            </div>
            <div class="form-group">
                <label for="zaal">Room</label>
                <select class="form-control" name="zaal">
                    <?php

                        while ($row = $resultZalen->fetch_assoc()) {
                            $idzaal = $row["idzalen"];
                            $naam = $row["naam"];
                            $capaciteit = $row["capaciteit"];

                            if($zaalid == $idzaal){
                                $current = "selected";
                            } else {$current = "";}

                            echo "<option ". $current ." value=". $idzaal .">". $naam ." -- </i> Cap. ". $capaciteit ."</option>";
                        }

                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="spreker">Speaker</label>
                <select class="form-control" name="spreker">
                    <?php

                        while ($row = $resultSprekers->fetch_assoc()) {
                            $idspreker = $row["idsprekers"];
                            $voornaam = $row["voornaam"];
                            $naam = $row["naam"];

                            if($sprekerid == $idspreker){
                                $current = "selected";
                            } else {$current = "";}

                            echo "<option ". $current ." value=". $idspreker .">". $voornaam . " " . $naam ."</option>";
                        }
                    ?>
                </select>
            </div>
            <button name="submit" type="submit" class="btn btn-primary">Edit Session</button>
        </form>
    </section>
</main>

<!-- Start Footer -->
<footer>
    <div class="row container bold">
        <div class="col-lg-3">
            <h4>INFORMATION</h4>
            <ul>
                <li><a href="#">Home</a></li>
                <li><a href="#">Coverage</a></li>
                <li><a href="#">Pricing</a></li>
                <li><a href="#">Buy</a></li>
            </ul>
        </div>
        <div class="col-lg-3">
            <h4>ABOUT</h4>
            <ul>
                <li><a href="#">About us</a></li>
                <li><a href="#">Blog</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Service</a></li>
            </ul>
        </div>
        <div class="col-lg-3">
            <h4>HELP</h4>
            <ul>
                <li><a href="#">Help Center</a></li>
                <li><a href="#">Get Started</a></li>
            </ul>
        </div>
        <div class="col-lg-3">
            <h4>CONTACT</h4>
            <ul>
                <li><a href="#"><i class="fab fa-facebook-square"></i>Facebook</a></li>
                <li><a href="#"><i class="fab fa-linkedin"></i>LinkedIN</a></li>
                <li><a href="#"><i class="fab fa-twitter-square"></i>Twitter</a></li>
            </ul>
        </div>
    </div>
</footer>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
        integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
        crossorigin="anonymous"></script>
</body>
</html>