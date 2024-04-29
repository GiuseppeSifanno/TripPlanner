<!DOCTYPE html>
    <html lang="it">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Trip Planner</title>

            <link rel="stylesheet" href="/TripPlanner/Style/stile.css" type="text/css">

            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
                integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
                integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
                crossorigin="anonymous"></script>
            <?php 
                session_start();
                if($_SESSION['consenti'] == false){
                    echo "<script>alert('Accesso non consentito')</script>";
                    header('refresh:5; url=/TripPlanner/index.php');
                };
            ?>
        </head>
        <body>
            <?php include_once 'navbar.html' ?>
            <div class="container text-center" style="text-align: justify;">
                <h3>Non sono presenti viaggi, per iniziare perchè non<a href="/TripPlanner/areaPrivata/creaViaggio.php">creane uno</a>?</h3>
            </div>
        </body>