<?php
date_default_timezone_set("Europe/Brussels");
error_reporting(E_ALL);
ini_set('display_errors', 'On');

require_once("scripts/database.php");

?>


<!doctype html>
<html lang="en">

<head>
<title>MM - Speaker Details</title>
<!-- Required meta tags -->
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<!-- Bootstrap CSS -->
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
    integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- Custom CSS-->
<link rel="stylesheet" href="style/style.css" type="text/css">
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
                            <a class="nav-link" href="index.php">HOME</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="overzicht_spreker.php?p=1">SPEAKERS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="overzicht_zalen.php">SCHEDULE</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#">SPONSORS</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin/sessies.php">TICKETS</a>
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
                <img src="images/logo.svg" width="350" class="d-inline-block align-center" alt="">
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarTogglerDemo02"
                aria-controls="navbarTogglerDemo02" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTogglerDemo02">
                <ul class="navbar-nav ml-auto mt-2 mt-lg-0 bold">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">HOME</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="overzicht_spreker.php?p=1">SPEAKERS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="overzicht_zalen.php">SCHEDULE</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">SPONSORS</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="admin/sessies.php">TICKETS</a>
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

<main class="spreker-wrap">

    <?php

        if(isset($_GET["idsprekers"])){

            $stmt = $mysqli->prepare("SELECT DISTINCT s.idsprekers, s.voornaam, s.naam, s.afbeelding, s.lanidID, s.bio, k.likecounter FROM sprekers s INNER JOIN sessies k ON s.idsprekers = k.sprekerID WHERE s.idsprekers = ?");
            $stmt->bind_param("i", $_GET['idsprekers']);
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows === 0) exit('Could not find this user in the database');
            while($row = $result->fetch_assoc()) {
                $id = $row['idsprekers'];
                $naam = $row['naam'];
                $voornaam = $row['voornaam'];
                $afbeelding = $row['afbeelding'];
                $bio = $row['bio'];
                

                // Filling in html
                echo "<div class='detail_spreker heart_fix d-flex justify-content-between'>";
                echo "<div>";

                if($row["afbeelding"] != null ){
                    echo "<img src='images/speakers/x500/". $row["afbeelding"] ."' alt='profile picture'>";
                } else{
                    echo "<img src='images/speakers/placeholder-f.jpg' alt='placeholder'>";
                }

                echo "<div>";

                $maxLength = 200;
                if (strlen($row["bio"]) > $maxLength)
                {
                    $lastPos = ($maxLength - 3) - strlen($row["bio"]);
                    $bio = substr($row["bio"], 0, strrpos($row["bio"], ' ', $lastPos)) . ' ...';
                }
                echo "<p>". $bio ."</p>";

                echo "<div class='buttons'>";
                echo "<div class='d-flex justify-content-between text-center'>";
                echo "<a target='_blank' href='https://www.facebook.com/". $row["voornaam"] . $row["naam"] ."'><i class='fab fa-facebook-square'></i></a>";
                echo "<a target='_blank' href='https://www.twitter.com/". $row["voornaam"] . $row["naam"] ."'><i class='fab fa-twitter-square'></i></a>";
                echo "<div class='like'>";
                echo "<div>";
                echo "<a class='heart' href='like_code.php?idsprekers=". $row["idsprekers"] ."'><i class='far fa-heart'></i></a>";
                echo "</div>";
                echo "<div>";
                echo "<span>". $row["likecounter"] ." Likes</span>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

                echo "<div>";
                echo "<h1 class='bold'>". $row["voornaam"] . " " . $row["naam"] . "</h1>";
                echo "<h3>Bedrijf</h3>";
                echo "<div class='info d-flex justify-content-between'>";
                echo "<div>";
                echo "<h2>BIO</h2>";
                echo "<p>". $row["bio"] ."</p>";
                echo "</div>";
                echo "<div>";
                echo "<h2>Socials</h2>";
                echo "<ul>";
                echo "<li><a href='#'>". $row["voornaam"] . $row["naam"]. ".be</a></li>";
                echo "<li><a href='#'>facebook.be/". $row["voornaam"] ."_". $row["naam"] ."</a></li>";
                echo "<li><a href='#'>twitter.be/#". $row["voornaam"] . $row["naam"]. "</a></li>";
                echo "</ul>";
                echo "</div>";
                echo "</div>";
                echo "</div>";
                echo "</div>";

            }
            $stmt->close();

        } else{
            header("Location: {$_SERVER['HTTP_REFERER']}");
        }

        
    ?>

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

<!-- Optional JavaScript -->
<!-- jQuery first, then Popper.js, then Bootstrap JS -->
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"
    integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous">
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
    integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
    integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
</body>

</html>