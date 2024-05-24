<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trip Planner</title>

    <link rel="stylesheet" href="/TripPlanner/Style/stile.css" type="text/css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <?php
        session_start();
        if ($_SESSION['consenti'] == false) {
            echo "<script>alert('Accesso non consentito')</script>";
            header('refresh:5; url=/TripPlanner/index.php');
        };
    ?>
</head>

<body>
    <?php include_once "navbar.html"; ?>
    <div style="display: flex; justify-content: center; margin: 40px; margin-top: 20px;">
        <div class="container-lg my-3" id="ctn-viaggi">
            <form method="post" action="/TripPlanner/Server/viaggio.php" id="FormViaggi">
                <div class="form-group">
                    <div class="container-sm">
                        <nav class="navbar navbar-expand" id="bar">
                            <div class="collapse navbar-collapse column-gap-3 row-gap-2" id="navbarSupportedContent" style="width: -webkit-fill-available; flex-wrap: wrap; justify-content: center;">
                                <input type="search" class="form-control" style="width: auto;" placeholder="Digita il nome del luogo" aria-label="Search" id="search">
                                <input type="text" class="form-control" style="width: auto;" placeholder="Nome del viaggio" id="nomeViaggio" name="nomeViaggio" required>
                            </div>
                            <div class="btn-group column-gap-3 container row-gap-2" role="group" id="button">
                                <input type="button" class="btn btn-sm rounded-1" name="AggiungiTappa" id="AggiungiTappa" value="AGGIUNGI" style="width: auto;" onclick="cercaTappa()" contenteditable="false">
                                <input type="submit" class="btn btn-sm rounded-1" id="CreaViaggio" value="CREA" style="width: auto;" id="btn-crea">
                            </div>
                        </nav>
                    </div>
                </div>

                <!-- Contenitore che contiene tutti i viaggi selezionati -->
                <div class="form-control" id="ctn-tappe">
                    <div id="msgDefault" style="display: flex; justify-content: center; padding-top: 20px; padding-bottom: 20px">
                        <h3>Non sono presenti tappe, digita il nome di una tappa e poi prima su <b>INVIA</b></h3>
                    </div>
                    <div class="row row-cols-1 row-cols-md-2 gy-4" id="cardGroup">
                    </div>
                </div>
            </form>
        </div>
    </div>

    <script>
        var msgDefault = document.getElementById("msgDefault");
        var viaggi = document.getElementById("cardGroup");

        function cercaTappa() {

            //chiamata all'api
            var testo = document.getElementById("search");
            if (testo.value !== "") {
                const xhttp = new XMLHttpRequest();
                console.log("xhttp");
                /*xhttp.readyState = function() {
                    //if(this.readyState == 4 && this.status == 200){
                        xhttp.responseType = 'json';
                        console.log("2");
                        aggiungiTappa(xhttp.response);
                    //}
                }*/

                var url = "https://script.google.com/macros/s/AKfycbw0EWYZotSupOburXtAMiWUcYkGN8rpETJloMKF2GIojZZ1L1NQcn2RMkgfy5zIx-I7/exec";

                fetch(url + "?tappa=" + testo.value).then(response => {
                    console.log('object :>> ', response.json().then(response => {
                        console.log(response);
                        aggiungiTappa(response);
                        //response.json().then(json => aggiungiTappa(json)); 
                    }));
                }).catch(error => console.log("Si è verificato un errore!"));
                /*xhttp.open('GET', url+'?tappa='+testo.value);
                xhttp.send();*/
            }
        }

        function aggiungiTappa(json) {
            jsonParse = JSON.parse(JSON.stringify(json));
            console.log(jsonParse);
            var id = viaggi.childElementCount++;
            console.log(id);
            var display_name = jsonParse.display_name;
            console.log(display_name);
            var lat = jsonParse.lat;
            var lon = jsonParse.lon;

            var cardTappa = document.createElement("div");
            cardTappa.id = id;
            cardTappa.classList.add("card");
            cardTappa.classList.add("text-left");
            cardTappa.classList.add("border-0");
            cardTappa.innerHTML = "<div class='col'><div class='card text-left' id='card'><div class='card-body'><h4 class='card-title' name='display_name'>" + display_name + "</h4><input type='hidden' name='display_name[]' value='" + display_name + "'><input type='hidden' name='lat[]' value='" + lat + "'><input type='hidden' name='lon[]' value='" + lon + "'></div><div class='p-3' id='comandi'><button type='button' class='btn btn-outline p-2' id='btn-delete' onclick='cancella("+id+")'><img src='../Icone/trash.svg' alt='Elimina' role='button'></button></div></div></div>";

            //aggiunge la tappa nel contenitore 
            viaggi.appendChild(cardTappa);
        }

        function cancella(idTappa) {
            if (confirm("Sicuro di voler eliminare questa tappa?")) viaggi.removeChild(document.getElementById(idTappa));
            else return;

            if (viaggi.hasChildNodes()) {
                msgDefault.style.display = 'none';
                document.getElementById("CreaViaggio").classList.add("active");
            } else {
                msgDefault.style.display = 'flex';
                document.getElementById("btn-crea").classList.add("disabled");
            }
        }
    </script>
</body>

</html>