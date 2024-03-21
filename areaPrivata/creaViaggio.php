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
            <!-- <?php 
                session_start();
                if(!isset($_SESSION['Consenti']) && $_SESSION['Consenti']){
                    echo "<script>alert('Accesso non consentito')</script>";
                    header('Location: /TripPlanner/index.php');
                };
            ?> -->  
        </head>

        <body>
            <?php include "../navbar.html"?>

            <div class="container my-3 shadow-lg p-0" style="width: 60%;">
                <form method="post" action="/Server/CreaViaggio.php" class="form-control" id="FormViaggi">
                    <div class="form-group">
                        <div class="container-fluid">
                            <nav class="navbar navbar-expand" style="column-gap: 25px;">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <input type="search" class="form-control" placeholder="Digita il nome del luogo" aria-label="Search" id="search">
                                </div>
                                <div class="btn-group col-4 column-gap-2" role="group">
                                    <input type="button" class="btn btn-sm btn-success rounded-1 w-50" name="AggiungiTappa" id="AggiungiTappa" value="Aggiungi Tappa" onclick="cercaTappa()" contenteditable="false">
                                    <input type="submit" class="btn btn-sm btn-danger rounded-1 w-50" id="CreaViaggio" value="Crea Viaggio" style="margin: 0;">    
                                </div>
                            </nav>
                        </div>
                    </div>
                </form>
                <!-- Contenitore che contiene tutti i viaggi selezionati -->
                <div class="form-control" id="ctn-viaggi">
                    Lorem ipsum dolor sit amet consectetur, adipisicing elit. Dicta, ullam perferendis dolorum 
                    possimus neque praesentium nihil magni atque tempora animi? Consequatur numquam, aspernatur 
                    cupiditate ab nam labore tenetur nobis nulla!
                </div>
            </div>
            <script>
                const testo = document.getElementById("search");
                testo.oninput = function () {
                    //console.log(testo.value);
                    if(isNaN(testo.value) && testo.value !== ""){
                        //console.log(testo.value);
                        const xhttp = new XMLHttpRequest();
                        xhttp.onload = function() {
                            var xml = xhttp.responseText;
                            var parser = new DOMParser();
                            //console.log(studenti);
                            VisualizzaLuoghi(parser.parseFromString(xml, "text/html"));
                        }

                        xhttp.open('GET', "Server.php?parola="+testo.value);
                        xhttp.send();
                    }
                };
            </script>

            <script>
                var viaggi = document.getElementById("ctn-viaggi");

                function cercaTappa(){
                    //chiamata all'api
                }

                function aggiungiTappa(){
                    //aggiunge la tappa nel contenitore 
                }

                function cancella(idTappa){
                    viaggi.removeChild(document.getElementById(idTappa));
                }
            </script>
        </body>
    </html>