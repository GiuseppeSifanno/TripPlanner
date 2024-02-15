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
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </head>
    <body onload=setFoto()>
        <div class="container">
        <header>
            <div class="container-md container-fluid">
                <nav class="navbar navbar-expand-sm" id="navbar">
                    <div class="container-fluid">
                        <a class="navbar-brand" href="#">Nome del sito</a>
                        <button class="navbar-toggler border-0" id="nav-menu" type="button" data-bs-toggle="collapse" data-bs-target="#navbarText"
                            aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse justify-content-end" id="navbarText">
                            <ul class="navbar-nav mb-2 mb-lg-0 column-gap-5">
                                <li class="nav-item">
                                    <a class="nav-link active" aria-current="page" href="#">Crea il tuo viaggio</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link img-thumbnail" href="#">
                                        <img src="/TripPlanner/Icone/account_circle_FILL0_wght400_GRAD0_opsz24.svg"
                                            class="text-decoration-none">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <span class="container-md container-fluid my-5" style="position: absolute; display: flow ; width: 55%; 
                    height: fit-content; color: whitesmoke; text-wrap:pretty;" id="introduzione">
            <h1>Pianifica al miglior modo tutte le tue tappe del tuo viaggio</h1>
            <h3 class="my-4">
                Utilizza i nostri strumenti per creare mappe aggiungendo, rimuovendo e modificando le varie tappe a seconda
                dei casi
            </h3>
            <div class="btn-group column-gap-3" id="bottoni-group" role="group">
                <div id="btn-inizia-ctn" class="my-2 my-1">
                    <button class="btn p-2" id="btn-inizia" style="overflow-wrap: break-word ;">CREA IL TUO PRIMO VIAGGIO</button>
                </div>
                <div id="btn-inizia-ctn" class="my-2">
                    <button class="btn p-2" id="btn-login">ACCEDI</button>
                </div>
            </div>
            
        </span>
        </div>
        

        <script type="text/javascript">
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
        </script>
    </body>
</html>