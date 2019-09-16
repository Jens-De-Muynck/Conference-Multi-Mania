<?php
    date_default_timezone_set("Europe/Brussels");
    error_reporting(E_ALL);
    ini_set('display_errors', 'On');

    // Connectie met DB
    require_once("scripts/database.php");

?>

<!doctype html>
<html lang="en">

<head>
    <title>MM - Home</title>
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
                            <a class="nav-link active" href="index.php">HOME <span class="sr-only">(current)</span></a>
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
                        <a class="nav-link active" href="index.php">HOME <span class="sr-only">(current)</span></a>
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

    <main>
        <!-- Start Carousel -->
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="3"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="4"></li>
            </ol>
            <div class="carousel-inner">
                <?php 

                    // Random articles// SQL query
                    $sql = "SELECT s.titel, s.omschrijving, s.afbeelding, z.naam, z.idzalen FROM sessies s INNER JOIN zalen z ON s.zaalID = z.idzalen ORDER BY RAND() LIMIT 5";

                    $result = $mysqli->query($sql);

                    if ($result->num_rows > 0) {
                        // output data of each row
                        $num_slide = 0;
                        while($row = $result->fetch_assoc()) {
                            $num_slide += 1;

                            $titel = strtoupper($row["titel"]);
                            $naam = strtoupper($row["naam"]);
                            $afbeelding = $row["afbeelding"];
                            $omschrijving = $row["omschrijving"];

                            if($row["idzalen"] == 100){
                                $naam = "PIXEL 1";
                            }

                            if($num_slide == 1){
                                $active = "active";
                            } else{
                                $active = "";
                            }

                            echo "<div class='carousel-item ". $active . "'>";
                            echo    "<img class='w-100' src='". $row["afbeelding"] ."' alt='Slide ". $num_slide ."'>";
                            echo    "<div class='content position-absolute container flex-column'>";
                            echo        "<h1 class='bold'>". $titel ."</h1>";
                            echo        "<div class='desc d-flex flex-row flex-wrap'>";
                            echo            "<h3 class='bold'>". $naam ."</h3>";
                            echo            "<p class='w-50'>". $omschrijving ."</p>";
                            echo        "</div>";
                            echo    "</div>";
                            echo "</div>";
                        }
                    } else {
                        echo "Could not fetch sessions from the database...";
                    }

                ?>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <!-- Start Articles -->
        <div class="articles container-fluid">
            <h3>About the conference</h3>
            <div class="row">

                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="img-wrap">
                        <img src="images/articles/Person.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">Eboy Happy 13</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="img-wrap">
                        <img src="images/articles/code.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">Hacking the newsroom</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">

                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">Show some f*cking empathy</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="img-wrap">
                        <img src="images/articles/phone.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                </div>

                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">HYPE: Combining Creativity & Code</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                    <div class="img-wrap">
                        <img src="images/articles/hype.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="img-wrap">
                        <img src="images/articles/mac.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">The art of emotional design</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 article d-flex align-items-center">
                    <div class="img-wrap">
                        <img src="images/articles/pixel.jpg" alt="">
                        <span class="color-overlay"></span>
                    </div>
                    <div class="article-wrap d-flex flex-column justify-content-center">
                        <h3 class="bold">Sex, Drugs and Rock & Roll: One pixel at a time</h3>
                        <p>
                            Duis luctus odio in nibh cursus egestas.
                            Nulla placerat, enim sit amet finibus
                            aliquet.
                        </p>
                        <a class="bold d-flex justify-content-space-between" href="#">Read more <i
                                class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>

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