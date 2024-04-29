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
                    header('refresh: 5; url=/TripPlanner/index.php');
                };
            ?>
            
            <script>
                function setFoto(){
                    const xhttp = new XMLHttpRequest();
                    xhttp.onload =function() {
                        let img = "url(/TripPlanner/Sfondi/".concat(xhttp.responseText);
                        document.body.style.backgroundImage = "linear-gradient(to right, rgba(12, 12, 12, 0.782), rgba(53, 50, 50, 0.327)),".concat(img);
                        document.body.id = "sfondo";
                    }
                    //si puo nascondere il percorso
                    xhttp.open('POST', "/TripPlanner/Server/getImmagine.php");
                    xhttp.send();
                }
                setFoto();
            </script>
        </head>

        <body>
            <?php include './navbar.html'?>
            <div class="container">
                <span class="container-md container-fluid my-5" style="position: absolute; display: flow ; width: 55%; 
                            height: fit-content; color: whitesmoke; text-wrap:pretty;" id="introduzione">
                    <h5 class="my-4">
                        Benvenuto nella tua zona privata, tramite questa pagina potrai <a href="visualizzaViaggi.php?SID=<?php session_id()?>">visulizzare i tuoi viaggi</a>
                        oppure potrai direttamente <a href="creaViaggio.php">crearne uno tu</a>
                    </h5>
                </span>
            </div>
        </body>
    </html>