<?php
date_default_timezone_set("Europe/Brussels");
error_reporting(E_ALL);
ini_set('display_errors', 'On');

    // Connectie met DB
    require_once("scripts/database.php");

    require_once("scripts/functions.php");

?>

<!doctype html>
<html lang="en">

<head>
    <title>MM - Overview Speakers</title>
    <!-- Required meta tags -->
    <meta charset="utf-16">
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
                        <a class="nav-link active" href="overzicht_spreker.php?p=1">SPEAKERS <span class="sr-only">(current)</span></a>
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
                    <a class="nav-link active" href="overzicht_spreker.php?p=1">SPEAKERS <span class="sr-only">(current)</span></a>
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

    <main class="sprekers">

        <div class="sorter bold container">
            <a class="<?php if(isset($_GET["q"])){if ($_GET['q'] == "1") echo 'active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("q", 1); ?>">Newest</a>
            <a class="<?php if(isset($_GET["q"])){if ($_GET['q'] == "2") echo 'active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("q", 2); ?>">Most Likes</a>
            <a class="<?php if(isset($_GET["q"])){if ($_GET['q'] == "3") echo 'active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("q", 3); ?>">Most popular</a>
        </div>

        <div class="sprekerslijst container d-flex justify-content-center flex-wrap">
            
            <?php
            
                if(isset($_GET["p"]))
                {
                    switch($_GET["p"]){
                        case 1:
                            $p = 'LIMIT 0, 8';
                            break;
                        case 2:
                            $p = 'LIMIT 8, 8';
                            break;
                        case 3:
                            $p = 'LIMIT 16, 8';
                            break;
                        case 4:
                            $p = 'LIMIT 24, 8';
                            break;
                        default:
                            $p = '';
                    }
                } else {$p = '';}

                
                // replace parameter(s)
                // rebuild url

                // SQL query
                $QueryDESC = "SELECT DISTINCT s.idsprekers, s.voornaam, s.naam, s.afbeelding, s.lanidID, s.bio, k.likecounter FROM sprekers s INNER JOIN sessies k ON s.idsprekers = k.sprekerID ORDER BY s.idsprekers DESC $p";
                $QueryASC = "SELECT DISTINCT s.idsprekers, s.voornaam, s.naam, s.afbeelding, s.lanidID, s.bio, k.likecounter FROM sprekers s INNER JOIN sessies k ON s.idsprekers = k.sprekerID ORDER BY s.idsprekers ASC $p";
                $QueryLIKES = "SELECT DISTINCT s.idsprekers, s.voornaam, s.naam, s.afbeelding, s.lanidID, s.bio, k.likecounter FROM sprekers s INNER JOIN sessies k ON s.idsprekers = k.sprekerID ORDER BY k.likecounter DESC $p";

                if(isset($_GET["q"])){
                    switch($_GET["q"]){

                        case 1:
                            $sqlQuery = $QueryDESC;
                            break;
                        case 2:
                            $sqlQuery = $QueryLIKES;
                            break;
                        case 3: 
                            $sqlQuery = $QueryASC;
                            break;
                        default: 
                            $sqlQuery = $QueryASC;
                    }
                } else{
                    $sqlQuery = $QueryASC;
                }
               
                $result = $mysqli->query($sqlQuery);

                if ($result->num_rows > 0) {
                    // output data of each row
                    while($row = $result->fetch_assoc()) {
                        echo "<div class='spreker'>";
                        echo "<div class='img-wrap position-relative'>";

                        if($row["afbeelding"] != null ){
                            echo "<img src='images/speakers/x250/". $row["afbeelding"] ."' alt='profile picture'>";
                        } else{
                            echo "<img src='images/speakers/placeholder-m.jpg' alt='profile picture'>";
                        }

                        echo "<span class='aantalLikes bold'>". $row["likecounter"] ." Likes</span>";
                        echo "<a class='heart' href='like_code.php?idsprekers=". $row["idsprekers"] ."'><i class='far fa-heart'></i></a>";
                        echo "</div>";

                        echo "<div class='bio-wrap'>";
                        echo "<h3 class='bold'>". $row["voornaam"] ." ". $row["naam"] ."</h3>";

                        $maxLength = 100;
                        if (strlen($row["bio"]) > $maxLength)
                        {
                            $lastPos = ($maxLength - 3) - strlen($row["bio"]);
                            $bio = substr($row["bio"], 0, strrpos($row["bio"], ' ', $lastPos)) . '...';
                        }
                        echo "<p>". $bio ."</p>";

                        echo "<a class='bold' href='detail_spreker.php?idsprekers=". $row["idsprekers"] ."'>More Info</a>";

                        echo "</div>";
                        echo "</div>";

                    }
                } else {
                    echo "0 results";
                }

            ?>

        </div>

        <div class="pagenav container text-center">
            <a class="arrow left" href=""><i class="fas fa-chevron-left"></i></a>
            <div class="bold pages d-inline-flex justify-content-around">
                <a class="<?php if(isset($_GET["p"])){if ($_GET['p'] == "1") echo ' active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("p", 1); ?>">1</a>
                <a class="<?php if(isset($_GET["p"])){if ($_GET['p'] == "2") echo ' active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("p", 2); ?>">2</a>
                <a class="<?php if(isset($_GET["p"])){if ($_GET['p'] == "3") echo ' active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("p", 3); ?>">3</a>
                <a class="<?php if(isset($_GET["p"])){if ($_GET['p'] == "4") echo ' active';} ?>" href="<?php echo $_SERVER['PHP_SELF']; ?>?<?php echo custom_url("p", 4); ?>">4</a>
                <a class="" href="#"><i class="fas fa-ellipsis-h"></i></a>
            </div>
            <a class="arrow right" href=""><i class="fas fa-chevron-right"></i></a>
        </div>
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