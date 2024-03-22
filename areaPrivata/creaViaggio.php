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

            <div class="container-lg my-3" id="ctn-viaggi">
                <form method="post" action="/Server/CreaViaggio.php" class="form-control" id="FormViaggi">
                    <div class="form-group">
                        <div class="container-sm">
                            <nav class="navbar navbar-expand" style="column-gap: 10px;">
                                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                    <input type="search" class="form-control" placeholder="Digita il nome del luogo" aria-label="Search" id="search">
                                </div>
                                <div class="btn-group col-6 column-gap-3" role="group">
                                    <input type="button" class="btn btn-sm btn-success rounded-1 w-50" name="AggiungiTappa" id="AggiungiTappa" value="Aggiungi" onclick="cercaTappa()" contenteditable="false">
                                    <input type="submit" class="btn btn-sm btn-danger rounded-1 w-50" id="CreaViaggio" value="Crea" style="margin: 0;" id="btn-crea">    
                                </div>
                            </nav>
                        </div>
                    </div>
                </form>
                <!-- Contenitore che contiene tutti i viaggi selezionati -->
                <div class="form-control" id="ctn-tappe">
                    <div class="row row-cols-1 row-cols-md-2 g-4" id="cardGroup">
                        <div class='col' id='1'>
                            <div class='card text-left' id='card'>
                                <div class='card-body'> 
                                    <h4 class='card-title'>Title</h4>
                                    <p class='card-text'>Body</p>
                                    
                                </div>
                                <div class='p-3' id='comandi'>
                                    <button type='button' class='btn btn-outline p-2' id='btn-delete' onclick='cancella(1)'>
                                        <img src='../Icone/trash.svg' alt='Elimina' role='button'>
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class='col' id='i'>
                            <div class='card text-left' id='card'>
                                <div class='card-body'> 
                                    <h4 class='card-title'>Title</h4>
                                    <p class='card-text'>ciao</p>
                                </div>
                                <div class='p-3' id='comandi'>
                                    <button type='button' class='btn btn-outline p-2' id='btn-delete' onclick='cancella(i)'>
                                        <img src='../Icone/trash.svg' alt='Elimina' role='button'>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <script>
                var viaggi = document.getElementById("cardGroup");

                function cercaTappa(){
                    //chiamata all'api
                    var testo = document.getElementById("search");
                    if(testo.value !== ""){
                        const xhttp = new XMLHttpRequest();
                        xhttp.readyState = function() {
                            if(this.readyState == 4 && this.status == 200){
                                var json = JSON.parse(xhttp.responseText);
                                aggiungiTappa(json);
                            }
                        }
                        //inserire il puntamento all'api appscript
                        xhttp.open('GET', "?tappa="+testo.value);
                        xhttp.send();
                    }
                }

                function aggiungiTappa(json){
                    var id = viaggi.childElementCount++;
                    var display_name = json[0].display_name;
                    var lat = json[0].lat;
                    var lon = json[0].lon; 

                    var cardTappa = document.createElement("div");
                    cardTappa.classList.add("card text-left");
                    cardTappa.innerHTML = "<div class='col' id='"+id+"'><div class='card text-left' id='card'><div class='card-body'><h4 class='card-title'>Title</h4><p class='card-text'>Body</p><input type='hidden' name='lat' value='"+lat+"'><input type='hidden' name='lon' value='"+lon+"'></div><div class='p-3' id='comandi'><button type='button' class='btn btn-outline p-2' id='btn-delete' onclick='cancella(i)'><img src='../Icone/trash.svg' alt='Elimina' role='button'></button></div></div></div>";

                    //aggiunge la tappa nel contenitore 
                    viaggi.appendChild(cardTappa);
                }

                function cancella(idTappa){
                    viaggi.removeChild(document.getElementById("id"));
                    if(viaggi.hasChildNodes())document.getElementById("btn-crea").classList.add("active");
                    else document.getElementById("btn-crea").classList.add("disabled");
                }
            </script>
        </body>
    </html>